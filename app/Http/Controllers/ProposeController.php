<?php

namespace App\Http\Controllers;

use App\ExternalMember;
use App\ModelSDM\Lecturer;
use App\Jobs\SendNotificationEmail;
use App\ProposeOutputType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Http\Requests;
use App\Propose;
use App\Propose_own;
use App\Member;
use App\Dedication_partner;
use App\Dedication_reviewer;
use App\FlowStatus;
use App\Output_type;
use App\Period;
use App\Category_type;
use App\Dedication_type;
use App\ModelSDM\Faculty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Input;
use View;

class ProposeController extends BlankonController {
    protected $pageTitle = 'Usulan';
    protected $deleteQuestion = 'Apakah anda yakin untuk menghapus Pengajuan Proposal ini?';
    protected $deleteUrl = 'proposes';
    protected $lv_disable;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isLecturer')->except('getFile');
        $this->middleware('isMember')->only('getFile', 'edit');
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jquery-ui/themes/base/jquery-ui.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/jquery-ui.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/ui/minified/autocomplete.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-autosize/jquery.autosize.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.advanced.js');
        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.element.js');
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
        $proposes = Propose::where('created_by', Auth::user()->nidn)->get();

        $members = Member::where('nidn', Auth::user()->nidn)->where('status', '<>', 'rejected')->get();
        foreach ($members as $member)
        {
            $propose = $member->propose()->first();
            if ($propose !== null)
            {
                $proposes->add($propose);
            }
        }

        $proposes = new Paginator($proposes, 10, Input::get('page', 1));

        if ($proposes->isEmpty())
        {
            $data_not_found = 'Data tidak ditemukan';
        }

        return view('propose.propose-list', compact('data_not_found', 'proposes'));
    }

    public function create()
    {
        $upd_mode = 'create';
        $this->lv_disable = null;

        $propose_relation = $this->getProposeRelationData();

        $disable_upload = false;
        $form_action = url('proposes/create');

        view::share('disabled', $this->lv_disable);

        return view('propose.propose-create', compact(
            'propose_relation',
            'disable_upload',
            'upd_mode',
            'form_action'
        ));

    }

    public function store(Requests\StoreProposeRequest $request)
    {
        if ($request->submit_button === 'save')
        {
            $lv_waiting = 'waiting';
        } else
        {
            $lv_waiting = 'no action';
        }
        $is_waiting = false;
        $proposes = new Propose();
        $flow_statuses = new FlowStatus();

        $proposes_own = new Propose_own();
        if ($request->is_own === '1')
        {
            $proposes->is_own = '1';
            if ($request['own-years'] !== '')
            {
                $proposes_own->years = $request['own-years'];
            }
            $proposes_own->dedication_type = $request['own-dedication_type'];
            $proposes_own->scheme = $request['own-scheme'];
            $proposes_own->sponsor = $request['own-sponsor'];
            if ($request['own-member'] !== '')
            {
                $proposes_own->member = $request['own-member'];
            }
            $proposes_own->annotation = $request['own-annotation'];
        } else
        {
            $proposes->period_id = $request->period_id;
        }

        $dedication_partners = new Collection();
        $i = 1;
        foreach ($request->partner_name as $key => $value)
        {
            $dedication_partner = new Dedication_partner();
            $dedication_partner->item = $i++;
            $dedication_partner->name = $request->partner_name[$key];
            $dedication_partner->territory = $request->partner_territory[$key];
            $dedication_partner->city = $request->partner_city[$key];
            $dedication_partner->province = $request->partner_province[$key];
            $dedication_partner->distance = $request->partner_distance[$key];
            $dedication_partner->file_partner_contract_ori = $request->file('file_partner_contract')[$key]->getClientOriginalName();
            $dedication_partner->file_partner_contract = md5($request->file('file_partner_contract')[$key]->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication_partner->item . '.pdf';
            $dedication_partners->add($dedication_partner);
        }

        $members = new Collection();
        $external_members = new Collection();
        $i = 1;
        foreach ($request->member_nidn as $key => $member_nidn)
        {
            if ($request['external' . $key] != '1')
            {
                $member = new Member();
                $member->item = $i++;
                $member->nidn = $member_nidn;
                $member->status = $lv_waiting;
                $member->areas_of_expertise = $request->member_areas_of_expertise[$key];
                $members->add($member);

                $is_waiting = true;
            } else
            {
                $member = new Member();
                $member->item = $i++;
                if ($request->submit_button === 'save')
                {
                    $member->status = 'accepted';
                } else
                {
                    $member->status = 'no action';
                }
                $member->areas_of_expertise = $request->member_areas_of_expertise[$key];
                $member->external = '1';
                $members->add($member);

                $external_member = new ExternalMember();
                $external_member->name = $request->external_name[$key];
                $external_member->affiliation = $request->external_affiliation[$key];
                $external_members->add($external_member);
            }
        }

        $propose_output_types = new Collection();
        $i = 1;
        foreach ($request->output_type as $item)
        {
            if ($item !== '')
            {
                $propose_output_type = new ProposeOutputType();
                $propose_output_type->item = $i++;
                $propose_output_type->output_type_id = $item;
                $propose_output_types->add($propose_output_type);
            }
        }

        $proposes->faculty_code = $request->faculty_code;
        $proposes->title = $request->title;
        if ($request->total_amount !== '')
        {
            $proposes->total_amount = str_replace(',', '', $request->total_amount);
        }
        if ($request->time_period !== '')
        {
            $proposes->time_period = $request->time_period;
        }
        $proposes->bank_account_name = $request->bank_account_name;
        $proposes->bank_account_no = $request->bank_account_no;
        if ($request->student_involved !== '')
        {
            $proposes->student_involved = $request->student_involved;
        }
        $proposes->areas_of_expertise = $request->areas_of_expertise;
        $proposes->address = $request->address;
        $proposes->created_by = Auth::user()->nidn;

        if ($is_waiting)
        {
            $flow_statuses->item = '1';
            $flow_statuses->status_code = 'VA'; //Menunggu Verifikasi Anggota
            $flow_statuses->created_by = $proposes->created_by;
        } else
        {
            $flow_statuses->item = '1';
            $flow_statuses->status_code = 'UU'; //Menunggu Unggah Usulan
            $flow_statuses->created_by = $proposes->created_by;
        }

        if ($request->submit_button !== 'save')
        {
            $flow_statuses->item = '1';
            $flow_statuses->status_code = 'SS'; //Simpan Sementara
            $flow_statuses->created_by = $proposes->created_by;
        }

        DB::transaction(function () use ($proposes, $proposes_own, $dedication_partners, $members, $external_members, $flow_statuses, $propose_output_types, $request)
        {
            $proposes->save();
            if ($proposes->is_own === '1')
            {
                $proposes->proposesOwn()->save($proposes_own);
            }
            $proposes->dedicationPartner()->saveMany($dedication_partners);
            $proposes->proposeOutputType()->saveMany($propose_output_types);
            $i = 0;
            foreach ($members as $key => $member)
            {
                if ($member->external === '1')
                {
                    $external_member = $external_members[$i];
                    $member->externalMember()->save($external_member);
                    $i++;
                }
            }
            $proposes->member()->saveMany($members);
            $proposes->flowStatus()->save($flow_statuses);

            //Send email to member
            $this->setEmail($flow_statuses->status_code, $proposes);

            $path = Storage::url('upload/' . md5(Auth::user()->nidn) . '/contract/');
            foreach ($dedication_partners as $key => $dedication_partner)
            {
                $request->file('file_partner_contract')[$key]->storeAs($path, $dedication_partner->file_partner_contract);
            }
        });

        return redirect()->intended('/proposes');
    }

    public function verification($id)
    {
        $this->lv_disable = 'disabled';
        $propose = Propose::find($id);

        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;

        $upd_mode = 'edit';
        view::share('disabled', $this->lv_disable);

        return view('propose.propose-verification', compact(
            'upd_mode',
            'propose_relation'
        ));
    }

    public function updateVerification(Requests\UpdateVerificationRequest $request, $id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        if ($request->reject === 'x')
        {
            $status = 'rejected';
        } else
        {
            $status = 'accepted';
        }

        $member_left_to_accept = $propose->member()->count() - $propose->member()->where('status', '<>', 'waiting')->count();
        $member_rejected = $propose->member()->where('status', 'rejected')->exists();

        $areas_of_expertise = '';
        foreach ($request->member_areas_of_expertise as $key => $item)
        {
            $areas_of_expertise = $item;
        }

        DB::transaction(function () use ($propose, $status, $member_left_to_accept, $member_rejected, $areas_of_expertise)
        {
            $propose->member()->where('nidn', Auth::user()->nidn)->update([
                'status'             => $status,
                'areas_of_expertise' => $areas_of_expertise
            ]);

            $this->setEmail($status, $propose);

            if ($member_left_to_accept === 1 && $member_rejected === false)
            {
                $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
                $propose->flowStatus()->create([
                    'item'        => $flow_status->item + 1,
                    'status_code' => 'UU', //Menunggu Unggah Usulan
                    'created_by'  => Auth::user()->nidn,
                ]);

                $this->setEmail('UU', $propose);
            }
        });

        return redirect()->intended('/proposes');
    }

    public function edit($id)
    {
        $upd_mode = 'edit';
        $this->lv_disable = 'disabled';
        $propose = Propose::find($id);

        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;

        $disable_upload = false;
        $status_code = $propose_relation->flow_status->status_code;
        if ($status_code !== 'UU' && $status_code !== 'PR')
        {
            $disable_upload = true;
        }

        $disable_final_amount = 'readonly';

        if ($status_code === 'SS')
        {
            // Initialize data for temporary saved proposes
            $propose_relation->periods = Period::where('propose_begda', '<=', Carbon::now()->toDateString())->where('propose_endda', '>=', Carbon::now()->toDateString())->get();
            if ($propose_relation->periods->isEmpty())
            {
                $propose_relation->period = new Period();
            } else
            {
                $propose_relation->period = $propose_relation->periods[0];
            }

            $form_action = url('proposes', $propose->id) . '/edit';
            $this->lv_disable = null;
            if ($propose_relation->propose_output_types->isEmpty())
            {
                $propose_relation->propose_output_types = new Collection();
                $propose_relation->propose_output_types->add(new ProposeOutputType());
                $propose_relation->propose_output_types->add(new ProposeOutputType());
                $propose_relation->propose_output_types->add(new ProposeOutputType());
            }
            if ($propose_relation->dedication_partners->isEmpty())
            {
                $propose_relation->dedication_partners = new Collection();
                $propose_relation->dedication_parnters->add(new Dedication_partner());
            }
            for ($i = count($propose_relation->propose_output_types); $i < 3; $i++)
            {
                $propose_relation->propose_output_types->add(new ProposeOutputType());
            }

            if ($propose_relation->members->isEmpty())
            {
                $propose_relation->members = new Collection;
                $propose_relation->member = new Member;
                $propose_relation->members->add(new Member);
            }

            $upd_mode = 'edit';
            view::share('disabled', $this->lv_disable);

            return view('propose.propose-create', compact(
                'upd_mode',
                'disable_upload',
                'form_action',
                'upd_mode',
                'propose_relation'
            ));
        } else
        {
            $upd_mode = 'edit';
            view::share('disabled', $this->lv_disable);

            return view('propose.propose-edit', compact(
                'upd_mode',
                'disable_upload',
                'status_code',
                'propose_relation',
                'disable_final_amount'
            ));
        }
    }


    public function update(Requests\StoreProposeRequest $request, $id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        if ($request->submit_button === 'print')
        {
            $propose_output_types = $propose->proposeOutputType()->get();
            $dedication_partners = $propose->dedicationPartner()->get();
            $lecturer = Lecturer::where('employee_card_serial_number', Auth::user()->nidn)->first();
            $lppm_head = Lecturer::where('employee_card_serial_number', '0001096202')->first();

            if ($request->sign_2 === 'secretary')
            {
                $lppm_head = Lecturer::where('employee_card_serial_number', '0009016502')->first();
            }

            $lppm_head->full_name = $lppm_head->front_degree . ' ' . $lppm_head->full_name . ', ' . $lppm_head->behind_degree;

            switch ($propose->faculty_code)
            {
                case 'FK':
                    $dean = Lecturer::where('employee_card_serial_number', '0024056603')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0025076506')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0005056702')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0021127302')->first();
                    break;
                case 'FH':
                    $dean = Lecturer::where('employee_card_serial_number', '0011055902')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0013026203')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0028016803')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0001087301')->first();
                    break;
                case 'FP':
                    $dean = Lecturer::where('employee_card_serial_number', '0008085812')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0002056904')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0001025904')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0002116403')->first();
                    break;
                case 'FT':
                    $dean = Lecturer::where('employee_card_serial_number', '0004016105')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0024125605')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0031126118')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0020086807')->first();
                    break;
                case 'FE':
                    $dean = Lecturer::where('employee_card_serial_number', '0002065803')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0013105907')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0002036006')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0007047403')->first();
                    break;
                case 'FKG':
                    $dean = Lecturer::where('employee_card_serial_number', '0014026503')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0012076404')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0002107801')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0020105502')->first();
                    break;
                case 'FIB':
                    $dean = Lecturer::where('employee_card_serial_number', '0005086002')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0029086106')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0027056012')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0025096203')->first();
                    break;
                case 'FMIPA':
                    $dean = Lecturer::where('employee_card_serial_number', '0023065803')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0023016305')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0015085603')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0010116812')->first();
                    break;
                case 'FISIP':
                    $dean = Lecturer::where('employee_card_serial_number', '0030097401')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0008037204')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0005107901')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0026026003')->first();
                    break;
                case 'FKM':
                    $dean = Lecturer::where('employee_card_serial_number', '0020036805')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0001056505')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '000111684')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0010115809')->first();
                    break;
                case 'FF':
                    $dean = Lecturer::where('employee_card_serial_number', '0023075705')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0020057505')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0015027803')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0020058001')->first();
                    break;
                case 'FPSI':
                    $dean = Lecturer::where('employee_card_serial_number', '0014127301')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0019087303')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0011117406')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0009096602')->first();
                    break;
                case 'FKEP':
                    $dean = Lecturer::where('employee_card_serial_number', '0020077102')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0015067901')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0026077702')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0027037502')->first();
                    break;
                case 'FIKTI':
                    $dean = Lecturer::where('employee_card_serial_number', '0017086108')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0016077001')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0029018304')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0027017403')->first();
                    break;
                case 'FAHUTA':
                    $dean = Lecturer::where('employee_card_serial_number', '0016047101')->first();
                    $vice_dean_1 = Lecturer::where('employee_card_serial_number', '0009047002')->first();
                    $vice_dean_2 = Lecturer::where('employee_card_serial_number', '0009017404')->first();
                    $vice_dean_3 = Lecturer::where('employee_card_serial_number', '0021048001')->first();
                    break;
            }
            if ($request->sign_1 === 'vice_dean_1')
            {
                $dean = $vice_dean_1;
            } elseif ($request->sign_1 === 'vice_dean_2')
            {
                $dean = $vice_dean_2;
            } elseif ($request->sign_1 === 'vice_dean_3')
            {
                $dean = $vice_dean_3;
            }
            if (! ($dean->front_degree === null || $dean->front_degree === '' || $dean->front_degree === '-'))
            {
                $dean->full_name = $dean->front_degree . ' ' . $dean->full_name;
            }
            if (! ($dean->behind_degree === null || $dean->behind_degree === '' || $dean->behind_degree === '-'))
            {
                $dean->full_name = $dean->full_name . ', ' . $dean->behind_degree;
            }

            $members = $propose->member()->get();
            foreach ($members as $member)
            {
                if ($member->external === '1')
                {
                    $external_member = $member->externalMember()->first();
                    $member->external_name = $external_member->name;
                    $member->external_affiliation = $external_member->affiliation;
                }
            }
            $month = date('M', strtotime(Carbon::now()->toDateString()));
            switch ($month)
            {
                case 'Jan':
                    $month = 'Januari';
                    break;
                case 'Feb':
                    $month = 'Pebruari';
                    break;
                case 'Mar':
                    $month = 'Maret';
                    break;
                case 'Apr':
                    $month = 'April';
                    break;
                case 'May':
                    $month = 'Mei';
                    break;
                case 'Jun':
                    $month = 'Juni';
                    break;
                case 'Jul':
                    $month = 'Juli';
                    break;
                case 'Aug':
                    $month = 'Agustus';
                    break;
                case 'Sep':
                    $month = 'September';
                    break;
                case 'Oct':
                    $month = 'Oktober';
                    break;
                case 'Nov':
                    $month = 'Nopember';
                    break;
                case 'Dec':
                    $month = 'Desember';
                    break;
            }
            $today_date = date('d', strtotime(Carbon::now()->toDateString())) . ' ' .
                $month . ' ' . date('Y', strtotime(Carbon::now()->toDateString()));

            $sign_1 = $request->sign_1;
            $sign_2 = $request->sign_2;

            return view('printing.print-confirmation', compact(
                'propose',
                'dedication_partners',
                'lecturer',
                'propose_output_types',
                'members',
                'today_date',
                'lppm_head',
                'dean',
                'sign_1',
                'sign_2'
            ));
        } else //Button Save
        {
            $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
            if ($flow_status->status_code === 'SS')
            {
                if ($request->submit_button === 'save')
                {
                    $lv_waiting = 'waiting';
                } else
                {
                    $lv_waiting = 'no action';
                }
                $is_waiting = false;
                $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();

                $proposes_own = new Propose_own();
                if ($request->is_own === '1')
                {
                    $propose->is_own = '1';
                    if ($request['own-years'] !== '')
                    {
                        $proposes_own->years = $request['own-years'];
                    }
                    $proposes_own->dedication_type = $request['own-dedication_type'];
                    $proposes_own->scheme = $request['own-scheme'];
                    $proposes_own->sponsor = $request['own-sponsor'];
                    if ($request['own-member'] !== '')
                    {
                        $proposes_own->member = $request['own-member'];
                    }
                    $proposes_own->annotation = $request['own-annotation'];
                } else
                {
                    $propose->is_own = null;
                    $propose->period_id = $request->period_id;
                }

                $dedication_partners = new Collection();
                $i = 1;
                foreach ($request->partner_name as $key => $value)
                {
                    $dedication_partner = new Dedication_partner();
                    $dedication_partner->item = $i++;
                    $dedication_partner->name = $request->partner_name[$key];
                    $dedication_partner->territory = $request->partner_territory[$key];
                    $dedication_partner->city = $request->partner_city[$key];
                    $dedication_partner->province = $request->partner_province[$key];
                    $dedication_partner->distance = $request->partner_distance[$key];
                    $dedication_partner->file_partner_contract_ori = $request->file('file_partner_contract')[$key]->getClientOriginalName();
                    $dedication_partner->file_partner_contract = md5($request->file('file_partner_contract')[$key]->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication_partner->item . '.pdf';
                    $dedication_partners->add($dedication_partner);
                }

                $members = new Collection();
                $external_members = new Collection();
                $i = 1;
                foreach ($request->member_nidn as $key => $member_nidn)
                {
                    if ($request['external' . $key] != '1')
                    {
                        $member = new Member();
                        $member->item = $i++;
                        $member->nidn = $member_nidn;
                        $member->status = $lv_waiting;
                        $member->areas_of_expertise = $request->member_areas_of_expertise[$key];
                        $members->add($member);

                        $is_waiting = true;
                    } else
                    {
                        $member = new Member();
                        $member->item = $i++;
                        if ($request->submit_button === 'save')
                        {
                            $member->status = 'accepted';
                        } else
                        {
                            $member->status = 'no action';
                        }
                        $member->areas_of_expertise = $request->member_areas_of_expertise[$key];
                        $member->external = '1';
                        $members->add($member);

                        $external_member = new ExternalMember();
                        $external_member->name = $request->external_name[$key];
                        $external_member->affiliation = $request->external_affiliation[$key];
                        $external_members->add($external_member);
                    }
                }

                $propose_output_types = new Collection();
                $i = 1;
                foreach ($request->output_type as $item)
                {
                    if ($item !== '')
                    {
                        $propose_output_type = new ProposeOutputType();
                        $propose_output_type->item = $i++;
                        $propose_output_type->output_type_id = $item;
                        $propose_output_types->add($propose_output_type);
                    }
                }

                $propose->faculty_code = $request->faculty_code;
                $propose->title = $request->title;
                if ($request->total_amount !== '')
                {
                    $propose->total_amount = str_replace(',', '', $request->total_amount);
                }
                if ($request->time_period !== '')
                {
                    $propose->time_period = $request->time_period;
                }
                $propose->bank_account_name = $request->bank_account_name;
                $propose->bank_account_no = $request->bank_account_no;
                if ($request->student_involved !== '')
                {
                    $propose->student_involved = $request->student_involved;
                }
                $propose->areas_of_expertise = $request->areas_of_expertise;
                $propose->address = $request->address;
                $propose->created_by = Auth::user()->nidn;

                $flow_statuses = new FlowStatus();
                if ($is_waiting)
                {
                    $flow_statuses->item = $flow_status->item + 1;
                    $flow_statuses->status_code = 'VA'; //Menunggu Verifikasi Anggota
                    $flow_statuses->created_by = $propose->created_by;
                } else
                {
                    $flow_statuses->item = $flow_status->item + 1;
                    $flow_statuses->status_code = 'UU'; //Menunggu Unggah Usulan
                    $flow_statuses->created_by = $propose->created_by;
                }

                if ($request->submit_button !== 'save')
                {
                    $flow_statuses->status_code = 'SS'; //Simpan Sementara
                    $flow_statuses->created_by = $propose->created_by;
                }

                DB::transaction(function () use ($propose, $proposes_own, $members, $external_members, $flow_statuses, $propose_output_types, $request)
                {
                    //Delete saved data to be overwritten with new data
                    DB::table('proposes_own')->where('propose_id', $propose->id)->delete();
                    $del_members = $propose->member()->get();
                    foreach ($del_members as $del_member)
                    {
                        $del_external = $del_member->externalMember()->first();
                        if ($del_external !== null) $del_external->delete();
                        $del_member->forceDelete();
                    }
                    DB::table('propose_output_types')->where('propose_id', $propose->id)->delete();
                    DB::table('dedication_partners')->where('propose_id', $propose->id)->delete();

                    //Now begin saving
                    $propose->save();
                    if ($propose->is_own === '1')
                    {
                        $propose->proposesOwn()->save($proposes_own);
                    }
                    $propose->member()->saveMany($members);
                    $proposes->dedicationPartner()->saveMany($dedication_partners);
                    $propose->proposeOutputType()->saveMany($propose_output_types);
                    $i = 0;
                    foreach ($members as $key => $member)
                    {
                        if ($member->external === '1')
                        {
                            $external_member = $external_members[$i];
                            $member->externalMember()->save($external_member);
                            $i++;
                        }
                    }
                    $propose->flowStatus()->save($flow_statuses);

                    //Send email to member
                    $this->setEmail($flow_statuses->status_code, $propose);

                    $path = Storage::url('upload/' . md5(Auth::user()->nidn) . '/contract/');
                    foreach ($dedication_partners as $key => $dedication_partner)
                    {
                        $request->file('file_partner_contract')[$key]->storeAs($path, $dedication_partner->file_partner_contract);
                    }
                });

                return redirect()->intended('/proposes');
            } else
            {
                $this->validate(
                    $request,
                    [
                        'file_propose' => 'required|mimes:pdf'
                    ],
                    [
                        'file_propose.required' => 'Usulan harus diunggah',
                        'file_propose.mimes'    => 'Usulan harus dalam bentuk PDF'
                    ]);
                DB::transaction(function () use ($propose, $request)
                {
                    $path = Storage::url('upload/' . md5(Auth::user()->nidn) . '/propose/');
                    if ($propose->file_propose !== null) //Delete old propose that already uploaded
                    {
                        Storage::delete($path . $propose->file_propose);
                    }
                    $propose->file_propose_ori = $request->file('file_propose')->getClientOriginalName();
                    $propose->file_propose = md5($request->file('file_propose')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $propose->id . '.pdf';
                    $propose->save();

                    $request->file('file_propose')->storeAs($path, $propose->file_propose);

                    $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
                    $store_flow_status = new FlowStatus();
                    $store_flow_status->item = $flow_status->item + 1;
                    if ($propose->is_own === '1')
                    {
                        $store_flow_status->status_code = 'RS'; // Review Selesai, Menunggu Hasil
                    } else
                    {
                        $store_flow_status->status_code = 'PR'; // Penentuan Reviewer
                    }
                    $store_flow_status->created_by = Auth::user()->nidn;

                    if ($flow_status->status_code === 'UU')
                    {
                        $propose->flowStatus()->save($store_flow_status);

                        $this->setEmail($store_flow_status->status_code, $propose);
                    }
                });

                return redirect()->intended('/proposes');
            }
        }
    }

    public function destroy($id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        DB::transaction(function () use ($propose, $id)
        {
            $propose->delete();
        });

        return redirect()->intended('/proposes');
    }

    public function getFile($id, $type)
    {
        if ($type == 1)
        {
            $dedication_partner = Dedication_partner::find($id);
            $nidn = $dedication_partner->propose()->first()->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/contract/' . $dedication_partner->file_partner_contract);

            $this->storeDownloadLog($dedication_partner->propose()->first()->id, 'contract', $dedication_partner->file_partner_contract_ori, $dedication_partner->file_partner_contract, $nidn);

            return response()->download($path, $dedication_partner->file_partner_contract_ori, ['Content-Type' => 'application/pdf']);
        } elseif ($type == 2)
        {
            $propose = Propose::find($id);
            $nidn = $propose->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/propose/' . $propose->file_propose);

            $this->storeDownloadLog($propose->id, 'propose', $propose->file_propose_ori, $propose->file_propose, $nidn);

            return response()->download($path, $propose->file_propose_ori, ['Content-Type' => 'application/pdf']);
        } elseif ($type == 3)
        {
            $propose = Propose::find($id);
            $nidn = $propose->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/propose/' . $propose->file_propose_final);

            $this->storeDownloadLog($propose->id, 'propose final', $propose->file_propose_final_ori, $propose->file_propose_final, $nidn);

            return response()->download($path, $propose->file_propose_final_ori, ['Content-Type' => 'application/pdf']);
        } else
        {
            $this->setCSS404();

            return abort('404');
        }
    }

    public function revision($id)
    {
        $this->lv_disable = 'disabled';
        $propose = Propose::find($id);

        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;
        $status_code = $propose_relation->flow_status->status_code;

        $disable_upload = true;
        $disable_final_amount = 'readonly';

        view::share('disabled', $this->lv_disable);

        return view('propose.propose-revision', compact(
            'propose_relation',
            'disable_upload',
            'status_code',
            'disable_final_amount'
        ));
    }

    public function revisionUpdate(Requests\StoreRevisionUpdateRequest $request, $id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        DB::transaction(function () use ($propose, $request)
        {
            $path = Storage::url('upload/' . md5(Auth::user()->nidn) . '/propose/');
            if ($propose->file_propose_final !== null) //Delete old propose that already uploaded
            {
                Storage::delete($path . $propose->file_propose_final);
            }
            $propose->file_propose_final_ori = $request->file('file_propose_final')->getClientOriginalName();
            $propose->file_propose_final = md5($request->file('file_propose_final')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $propose->id . '.pdf';
            $propose->save();

            $request->file('file_propose_final')->storeAs($path, $propose->file_propose_final);

            $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
            $propose->flowStatus()->create([
                'item'        => $flow_status->item + 1,
                'status_code' => 'UD', //Usulan Diterima
                'created_by'  => Auth::user()->nidn,
            ]);

            $propose->dedication()->create([
                'created_by' => Auth::user()->nidn,
            ]);
        });

        $this->setEmail('UD', $propose);

        return redirect()->intended('proposes');
    }

    public function display($id)
    {
        $propose = Propose::find($id);
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;
        $status_code = $propose_relation->flow_status->status_code;

        $upd_mode = 'display';
        $disabled = 'disabled';
        $disable_upload = true;
        $disable_final_amount = 'readonly';

        return view('propose.propose-edit', compact(
            'upd_mode',
            'disabled',
            'disable_upload',
            'status_code',
            'propose_relation',
            'disable_final_amount'
        ));
    }

    private function getProposeRelationData($propose = null)
    {
        $ret = new \stdClass();
        if ($propose !== null)
        {
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
        } else
        {
            $ret->propose = new Propose();
            $ret->propose_own = new Propose_own();

            $ret->periods = Period::where('propose_begda', '<=', Carbon::now()->toDateString())->where('propose_endda', '>=', Carbon::now()->toDateString())->get();
            if ($ret->periods->isEmpty())
            {
                $ret->period = new Period();
                $ret->propose->is_own = '1';
            } else
            {
                $ret->period = $ret->periods->get(0);
            }
            $ret->output_types = Output_type::all();
            $ret->output_types->add(new Output_type());
            $ret->category_types = Category_type::all();
            $ret->dedication_types = Dedication_type::all();
            $ret->propose_output_types = new Collection();
            $ret->propose_output_types->add(new ProposeOutputType());
            $ret->propose_output_types->add(new ProposeOutputType());
            $ret->propose_output_types->add(new ProposeOutputType());
            $ret->dedication_partners = new Collection();
            $ret->dedication_partners->add(new Dedication_partner());

            $ret->lecturer = $this->getEmployee(Auth::user()->nidn);

            $ret->members = new Collection;
            $ret->member = new Member;
            $ret->members->add(new Member);

            $ret->faculties = Faculty::where('is_faculty', '1')->where('faculty_code', '<>', 'SPS')->get();
        }

        return $ret;
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }

}
