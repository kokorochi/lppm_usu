<?php

namespace App\Http\Controllers;

use App\Auths;
use App\Dedication_partner;
use App\Dedication_reviewer;
use App\Dedication_type;
use App\FlowStatus;
use App\Member;
use App\ModelSDM\Faculty;
use App\ModelSDM\Lecturer;
use App\Output_type;
use App\Period;
use App\Propose;
use App\Propose_own;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use View;

class ReviewerController extends BlankonController {
    protected $pageTitle = 'Reviewer';
    protected $deleteQuestion = 'Apakah anda yakin untuk menghapus Pengajuan Proposal ini?';
    protected $deleteUrl = 'reviewers';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isOperator');
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jquery-ui/themes/base/jquery-ui.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/datatables/css/dataTables.bootstrap.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/datatables/css/datatables.responsive.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/fuelux/dist/css/fuelux.min.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/jquery-ui.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/ui/minified/autocomplete.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/jquery.dataTables.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/dataTables.bootstrap.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/datatables.responsive.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.advanced.js');
        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.element.js');
        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.picker.js');
        array_push($this->js['scripts'], 'admin/js/datatable-custom.js');
        array_push($this->js['scripts'], 'admin/js/customize.js');
        array_push($this->js['scripts'], 'admin/js/search-member.js');

        View::share('css', $this->css);
        View::share('js', $this->js);
        View::share('pageTitle', $this->pageTitle);
        View::share('title', $this->pageTitle . ' | ' . $this->mainTitle);
        View::share('deleteUrl', $this->deleteUrl);
        View::share('deleteQuestion', $this->deleteQuestion);
    }

    public function index()
    {
        $auths = Auths::where('auth_object_ref_id', '3')->paginate(10);
        $data_not_found = 'Tidak ada reviewer';
        foreach ($auths as $auth)
        {
            $auth->begin_date = date('d-M-Y', strtotime($auth->begin_date));
            $auth->end_date = date('d-M-Y', strtotime($auth->end_date));
        }

        return view('reviewer/reviewer-list', compact(
            'auths',
            'data_not_found'
        ));
    }

    public function create()
    {
        $auths = new Auths;
        $lecturer = new Lecturer;
        $upd_mode = 'create';

        return view('reviewer/reviewer-create', compact('auths', 'upd_mode', 'lecturer'));
    }

    public function store(Requests\StoreReviewer $request)
    {
        $user = User::where('nidn', $request->nidn)->first();

        $user->auths()->create([
            'auth_object_ref_id' => '3',
            'begin_date'         => date('Y-m-d', strtotime($request->begin_date)),
            'end_date'           => date('Y-m-d', strtotime($request->end_date)),
            'created_by'         => Auth::user()->nidn,
        ]);

        return redirect()->intended('reviewers/');
    }

    public function edit($id)
    {
        $auths = Auths::find($id);
        if ($auths === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $upd_mode = 'edit';
        $lecturer = $auths->user()->first()->lecturer()->first();
        $auths->nidn = $auths->user()->first()->nidn;
        $auths->full_name = $lecturer->full_name;
        $auths->begin_date = date('d-m-Y', strtotime($auths->begin_date));
        $auths->end_date = date('d-m-Y', strtotime($auths->end_date));

        return view('reviewer/reviewer-edit', compact(
            'auths',
            'upd_mode',
            'lecturer'
        ));
    }

    public function update(Requests\StoreReviewer $request, $id)
    {
        $auth = Auths::find($id);
        $auth->begin_date = date('Y-m-d', strtotime($request->begin_date));
        $auth->end_date = date('Y-m-d', strtotime($request->end_date));
        $auth->updated_by = Auth::user()->nidn;
        $auth->save();

        return redirect()->intended('reviewers/');
    }

    public function assignList()
    {
        $periods = Period::where('review_endda', '>=', Carbon::now()->toDateString())->get();
        $period = $periods[0];
        $proposes = $period->propose()->paginate(10);
        $data_not_found = 'Tidak ada pengajuan proposal untuk scheme ini';

        return view('reviewer/reviewer-assign-list', compact(
            'periods',
            'period',
            'proposes',
            'data_not_found'
        ));
    }

    public function assign($id)
    {
        $disable_reviewer = false;
        $propose = Propose::find($id);
        $dedication_reviewers = Dedication_reviewer::where('propose_id', $propose->id)->get();
        $dedication_reviewer = new Dedication_reviewer;
        if ($dedication_reviewers->isEmpty())
        {
            $dedication_reviewers = new Collection;
            $dedication_reviewers->add($dedication_reviewer);
        } else
        {
            foreach ($dedication_reviewers as $dedication_reviewer)
            {
                $dedication_reviewer->display = Lecturer::where('employee_card_serial_number', $dedication_reviewer->nidn)->first()->full_name;
                $dedication_reviewer->disabled = 'readonly';
            }
        }
        $propose_own = new Propose_own;
        $periods = Period::all();
        $period = $propose->period()->first();
        $members = $propose->member()->get();
        foreach ($members as $member)
        {
            $member['member_display'] = Member::where('id', $member->id)->where('item', $member->item)->first()->lecturer()->first()->full_name;
        }
        $dedication_partners = $propose->dedicationPartner()->get();
        $dedication_types = Dedication_type::all();
        $output_types = Output_type::all();
        $lecturer = Lecturer::where('employee_card_serial_number', $propose->created_by)->first();
        $faculties = Faculty::where('is_faculty', 1)->get();
        $disabled = 'disabled';
        $disable_upload = true;

        return view('reviewer/reviewer-assign', compact(
            'propose',
            'dedication_reviewers',
            'lecturer',
            'output_types',
            'faculties',
            'propose_own',
            'periods',
            'period',
            'dedication_partners',
            'dedication_types',
            'members',
            'disabled',
            'disable_upload',
            'disable_reviewer'
        ));
    }

    public function assignUpdate(Requests\StoreAssignReviewerRequest $request, $id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $dedication_reviewers = $propose->dedicationReviewer()->withTrashed()->get();
        $item_no = 1;
        if ($dedication_reviewers->isEmpty() === false)
        {
            $item_no = $dedication_reviewers->sortByDesc('item')->first()->item;
        }

        $dedication_review_restore = new Collection;
        $dedication_review_new = new Collection;
        $dedication_review_delete = new Collection;
        foreach ($request->nidn as $item)
        {   
            $dedication_review = $dedication_reviewers->where('nidn', $item)->first();
            if ($dedication_review !== null)
            {
                $dedication_review_restore->add($dedication_review);
            } else
            {
                $dedication_review = new Dedication_reviewer;
                $dedication_review->propose_id = $id;
                $dedication_review->nidn = $item;
                $dedication_review->item = $item_no++;
                $dedication_review_new->add($dedication_review);
            }
        }

        foreach ($dedication_reviewers as $dedication_reviewer)
        {
            if ($dedication_reviewer->deleted_at === null)
            {
                $pos = array_search($dedication_reviewer->nidn, $request->nidn);
                if ($pos === false)
                {
                    $dedication_review_delete->add($dedication_reviewer);
                }
            }
        }

        $flow_statuses = $propose->flowStatus()->orderBy('item', 'desc')->first();
        $flow_statuses->item = $flow_statuses->item + 1;
        $flow_statuses->status_code = 'MR'; //Menunggu diReview
        $flow_statuses->created_by = Auth::user()->nidn;

        DB::transaction(function() use($dedication_review_new, $dedication_review_restore, $dedication_review_delete, $flow_statuses){
            foreach ($dedication_review_restore as $item)
            {
                $item->restore();
                $item->updated_by = Auth::user()->nidn;
                $item->save();
            }
            foreach ($dedication_review_new as $item)
            {
                $item->created_by = Auth::user()->nidn;
                $item->save();
            }
            foreach ($dedication_review_delete as $item)
            {
                $item->updated_by = Auth::user()->nidn;
                $item->save();
                $item->delete();
            }
            $flow_statuses->save();
        });
        return redirect()->intended('reviewers/assign');
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
