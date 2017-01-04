<?php

namespace App\Http\Controllers;

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
    protected $pageTitle = 'Approve Proposal';
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
        $periods = Period::where('first_endda', '>=', Carbon::now()->toDateString())->get();

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
        $propose->final_amount = $propose->total_amount;

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
        if ($propose->is_own === '1')
        {
            $propose_own = $propose->proposesOwn()->first();
        } else
        {
            $propose_own = new Propose_own;
        }
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
        $disable_reviewer = true;
        $status_code = '';
        $disable_final_amount = '';

        return view('approve-propose/approve-propose-create', compact(
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
                if($propose->is_own === '1')
                {
                    $propose->flowStatus()->create([
                        'item'        => $flow_status->item + 1,
                        'status_code' => 'UL', // Menunggu Luaran
                        'created_by'  => Auth::user()->nidn,
                    ]);
                }
            }
        });

        return redirect()->intended('approve-proposes');
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
