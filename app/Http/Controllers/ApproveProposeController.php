<?php

namespace App\Http\Controllers;

use App\Auths;
use App\Dedication;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use View;
use App\Period;
use App\Propose;
use App\Dedication_reviewer;
use App\ModelSDM\Lecturer;
use App\Propose_own;
use App\Member;
use App\Dedication_type;
use App\Output_type;
use App\ModelSDM\Faculty;
use Illuminate\Support\Facades\Auth;


class ApproveProposeController extends BlankonController {
    protected $pageTitle = 'Proposal';
    protected $deleteQuestion = '';
    protected $deleteUrl = 'approve-proposes';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isOperator');
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
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
        $periods = Period::orderBy('id', 'desc')->get();

        $period = new Period();
        $period->id = '0';
        $period->scheme = 'Mandiri';
        $periods->add($period);

        $period = $periods[0];

        return view('approve-propose.approve-propose-list', compact(
            'periods',
            'period'
        ));
    }

    public function approve($id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;

        $dedication_reviewers = Dedication_reviewer::where('propose_id', $propose->id)->get();
        $dedication_reviewer = new Dedication_reviewer;
        if ($dedication_reviewers->isEmpty() &&
            $propose->is_own !== '1'
        )
        {
            $dedication_reviewers = new Collection();
            $dedication_reviewers->add($dedication_reviewer);
        } else
        {
            foreach ($dedication_reviewers as $dedication_reviewer)
            {
                $dedication_reviewer->display = Lecturer::where('employee_card_serial_number', $dedication_reviewer->nidn)->first()->full_name;
                $dedication_reviewer->disabled = 'readonly';
            }
        }
        $reviewers = Auths::where('auth_object_ref_id', '3')->get();
        foreach ($reviewers as $reviewer)
        {
            $lecturer = $reviewer->user()->first()->lecturer()->first();
            $reviewer->nidn = $lecturer->employee_card_serial_number;
            $reviewer->full_name = $reviewer->nidn . ' : ' . $lecturer->full_name;
        }

        $count_reviewers = count($dedication_reviewers);
        $review_proposes = $propose->reviewPropose()->get();
        $count_amount = 0;
        foreach ($review_proposes as $review_propose)
        {
            $count_amount += $review_propose->recommended_amount;
        }

        $propose_relation->propose->final_amount = $count_amount / $count_reviewers;

        $disabled = 'disabled';
        $disable_upload = true;
        $disable_reviewer = true;
        $status_code = '';
        $disable_final_amount = '';

        return view('approve-propose/approve-propose-create', compact(
            'propose_relation',
            'upd_mode',
            'reviewers',
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
            'disable_reviewer',
            'status_code',
            'disable_final_amount'
        ));
    }

    public function approveUpdate(Requests\StoreApproreUpdateRequest $request, $id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $status_code = '';
        $propose->final_amount = str_replace(',', '', $request->final_amount);
        if ($request->rejected == 1)
        {
            $status_code = 'UT'; //Usulan Ditolak
        } else
        {
            if ($propose->final_amount != $propose->total_amount)
            {
                $status_code = 'PU'; //Perbaikan, Menunggu Unggah Usulan Perbaikan
            } else
            {
                $status_code = 'UD'; //Usulan Diterima
            }
        }

        DB::transaction(function () use ($propose, $status_code)
        {
            $propose->save();
            $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
            $propose->flowStatus()->create([
                'item'        => $flow_status->item + 1,
                'status_code' => $status_code,
                'created_by'  => Auth::user()->nidn,
            ]);
            if ($status_code === 'UD')
            {
                $propose->dedication()->create([
                    'created_by' => Auth::user()->nidn,
                ]);
                if ($propose->is_own === '1')
                {
                    $propose->flowStatus()->create([
                        'item'        => $flow_status->item + 1,
                        'status_code' => 'UL', // Menunggu Luaran
                        'created_by'  => Auth::user()->nidn,
                    ]);
                }
            }
        });
        $this->setEmail($status_code, $propose);

        return redirect()->intended('approve-proposes');
    }

    public function display($id)
    {
        $propose = Propose::find($id);
        if($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;

        $dedication_reviewers = Dedication_reviewer::where('propose_id', $propose->id)->get();

        foreach ($dedication_reviewers as $dedication_reviewer)
        {
            $dedication_reviewer->display = Lecturer::where('employee_card_serial_number', $dedication_reviewer->nidn)->first()->full_name;
            $dedication_reviewer->disabled = 'readonly';
        }

        $reviewers = Auths::where('auth_object_ref_id', '3')->get();
        foreach ($reviewers as $reviewer)
        {
            $lecturer = $reviewer->user()->first()->lecturer()->first();
            $reviewer->nidn = $lecturer->employee_card_serial_number;
            $reviewer->full_name = $reviewer->nidn . ' : ' . $lecturer->full_name;
        }

        $count_reviewers = count($dedication_reviewers);
        $review_proposes = $propose->reviewPropose()->get();
        $count_amount = 0;
        foreach ($review_proposes as $review_propose)
        {
            $count_amount += $review_propose->recommended_amount;
        }

        if($count_reviewers === 0)
        {
            $propose_relation->propose->final_amount = $propose_relation->propose->total_amount;
        }else{
            $propose_relation->propose->final_amount = $count_amount / $count_reviewers;
        }

        $disabled = 'disabled';
        $disable_upload = true;
        $disable_reviewer = true;
        $status_code = '';
        $disable_final_amount = 'disabled';
        $upd_mode = 'display';

        return view('approve-propose/approve-propose-create', compact(
            'propose_relation',
            'reviewers',
            'dedication_reviewers',
            'upd_mode',
            'disabled',
            'disable_upload',
            'disable_reviewer',
            'status_code',
            'disable_final_amount'
        ));

        return view();
    }

    private function getProposeRelationData($propose = null)
    {
        $ret = new \stdClass();
        $ret->propose_own = $propose->proposesOwn()->first();
        $ret->periods = $propose->period()->get();
        $ret->period = $propose->period()->first();
        $ret->propose_output_types = $propose->proposeOutputType()->get();
        $ret->members = $propose->member()->get();
        $ret->flow_status = $propose->flowStatus()->orderBy('id', 'desc')->first();
        $ret->dedication_partners = $propose->dedicationPartner()->get();
        $ret->dedication_partner = $propose->dedicationPartner()->first();
        foreach ($ret->members as $member)
        {
            if ($member->external === '1')
            {
                $external_member = $member->externalMember()->first();
                $member->external_name = $external_member->name;
                $member->external_affiliation = $external_member->affiliation;
            } else
            {
                if ($member->nidn !== null && $member->nidn !== '')
                {
                    $member->member_display = $member->nidn . ' : ' . Member::where('id', $member->id)->where('item', $member->item)->first()->lecturer()->first()->full_name;
                    $member->member_nidn = $member->nidn;
                }
            }
        }
        $ret->member = $ret->members->get(0);
        $ret->lecturer = Lecturer::where('employee_card_serial_number', $propose->created_by)->first();
        $ret->faculties = Faculty::where('is_faculty', '1')->get();
        $ret->output_types = Output_type::all();
        $ret->output_types->add(new Output_type());
        $ret->dedication_types = Dedication_type::all();

        if ($ret->propose_own === null)
        {
            $ret->propose_own = new Propose_own();
        }
        if ($ret->periods === null)
        {
            $ret->periods = new Collection();
            $ret->periods->add(new Period);
        }
        if ($ret->period === null)
        {
            $ret->period = new Period();
        }

        return $ret;
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
