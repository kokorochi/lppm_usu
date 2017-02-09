<?php

namespace App\Http\Controllers;

use App\Dedication;
use App\DedicationOutputGeneral;
use App\DedicationOutputGuidebook;
use App\DedicationOutputMethod;
use App\DedicationOutputPatent;
use App\DedicationOutputProduct;
use App\DedicationOutputRevision;
use App\DedicationOutputService;
use App\Period;
use App\Propose;
use App\Member;
use App\ModelSDM\Lecturer;
use App\ModelSDM\Faculty;
use App\Output_type;
use App\Dedication_type;
use App\Propose_own;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Requests;
use App\Announce;
use Illuminate\Support\Facades\DB;
use View;

class DedicationController extends BlankonController {
    protected $pageTitle = 'Pengabdian';
    protected $deleteQuestion = '';
    protected $deleteUrl = 'dedications';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isLecturer')->except(['approveList', 'approveDetail', 'approveUpdate', 'getOutputFile']);
        $this->middleware('isOperator')->only(['approveList', 'approveDetail', 'approveUpdate']);
        $this->middleware('isLecturerOrOperator')->only(['getOutputFile']);
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jquery-ui/themes/base/jquery-ui.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/datatables/css/dataTables.bootstrap.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/datatables/css/datatables.responsive.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/fuelux/dist/css/fuelux.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/jquery-ui.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-ui/ui/minified/autocomplete.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/jquery.dataTables.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/dataTables.bootstrap.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/datatables/js/datatables.responsive.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js');

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
        $proposes = Propose::where('created_by', Auth::user()->nidn)->get();
        $dedications = new Collection();
        foreach ($proposes as $propose)
        {
            $dedication = $propose->dedication()->first();
            if ($dedication !== null) $dedications->add($dedication);
        }
        foreach ($dedications as $dedication)
        {
            $output_status = '';
            $dedication_output_generals = $dedication->dedicationOutputGeneral()->get();
            if ($dedication_output_generals->isEmpty())
            {
                $dedication->output_status = 'Luaran belum diunggah';
            } else
            {
                $output_flow_status = $dedication->outputFlowStatus()->orderBy('id', 'desc')->first();
                if ($output_flow_status->status_code !== null)
                {
                    $output_status = $output_flow_status->statusCode()->first()->description;
                } else
                {
                    foreach ($dedication_output_generals as $dedication_output_general)
                    {
                        if ($output_status == '')
                        {
                            $output_status = $dedication_output_general->output_description . ': ' . $dedication_output_general->status;
                        } else
                        {
                            $output_status = $output_status . '<br />' . $dedication_output_general->output_description . ': ' . $dedication_output_general->status;
                        }
                    }
                }
            }
            $dedication->output_status = $output_status;
        }

        $data_not_found = 'Data tidak ditemukan';

        return view('dedication.dedication-list', compact(
            'dedications',
            'data_not_found'
        ));
    }

    public function edit($id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $propose = $dedication->propose()->first();
        if ($propose === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        if ($propose->created_by !== Auth::user()->nidn)
        {
            $this->setCSS404();

            return abort('403');
        }

        $propose_relation = $this->getProposeRelationData($propose);
        $propose_relation->propose = $propose;

        if ($propose_relation->flow_status->status_code === 'UD')
        {
            $dedication->propose()->first()->flowStatus()->create([
                'item'        => $propose_relation->flow_status->item + 1,
                'status_code' => 'LK', //Menunggu Laporan Kemajuan
                'created_by'  => Auth::user()->nidn,
            ]);
            $propose_relation->flow_status->status_code = 'LK';
        }

        $disable_upload = false;
        $status_code = $propose_relation->flow_status->status_code;
        if ($status_code !== 'UU' && $status_code !== 'PR')
        {
            $disable_upload = true;
        }

        $disabled = 'disabled';
        $disable_final_amount = 'readonly';
        $upd_mode = 'edit';

        return view('dedication.dedication-edit', compact(
            'dedication',
            'propose_relation',
            'disable_upload',
            'status_code',
            'disable_final_amount',
            'disabled',
            'upd_mode'
        ));
    }

    public function updateProgress(Requests\StoreUpdateProgressRequest $request, $id)
    {
        $dedication = Dedication::find($id);

        DB::transaction(function () use ($dedication, $request)
        {
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/progress/');
            if ($dedication->file_progress_activity !== null) //Delete old propose that already uploaded
            {
                Storage::delete($path . $dedication->file_progress_activity);
                Storage::delete($path . $dedication->file_progress_budgets);
            }

            $dedication->file_progress_activity_ori = $request->file('file_progress_activity')->getClientOriginalName();
            $dedication->file_progress_activity = md5($request->file('file_progress_activity')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.pdf';

            $dedication->file_progress_budgets_ori = $request->file('file_progress_budgets')->getClientOriginalName();
            $dedication->file_progress_budgets = md5($request->file('file_progress_budgets')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.pdf';

            $dedication->updated_by = Auth::user()->nidn;
            $dedication->save();

            $request->file('file_progress_activity')->storeAs($path, $dedication->file_progress_activity);
            $request->file('file_progress_budgets')->storeAs($path, $dedication->file_progress_budgets);

            $flow_status = $dedication->propose()->first()->flowStatus()->orderBy('item', 'desc')->first();
            if ($flow_status->status_code === 'LK')
            {
                $dedication->propose()->first()->flowStatus()->create([
                    'item'        => $flow_status->item + 1,
                    'status_code' => 'LA', //Menunggu Laporan Akhir
                    'created_by'  => Auth::user()->nidn,
                ]);
            }

        });

        return redirect()->intended($this->deleteUrl);
    }

    public function updateFinal(Requests\StoreUpdateFinalRequest $request, $id)
    {
        $dedication = Dedication::find($id);

        DB::transaction(function () use ($dedication, $request)
        {
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/final/');
            if ($dedication->file_final_activity !== null) //Delete old propose that already uploaded
            {
                Storage::delete($path . $dedication->file_final_activity);
                Storage::delete($path . $dedication->file_final_budgets);
            }

            $dedication->file_final_activity_ori = $request->file('file_final_activity')->getClientOriginalName();
            $dedication->file_final_activity = md5($request->file('file_final_activity')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.pdf';

            $dedication->file_final_budgets_ori = $request->file('file_final_budgets')->getClientOriginalName();
            $dedication->file_final_budgets = md5($request->file('file_final_budgets')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.pdf';

            $dedication->updated_by = Auth::user()->nidn;
            $dedication->save();

            $request->file('file_final_activity')->storeAs($path, $dedication->file_final_activity);
            $request->file('file_final_budgets')->storeAs($path, $dedication->file_final_budgets);

            $flow_status = $dedication->propose()->first()->flowStatus()->orderBy('item', 'desc')->first();
            if ($flow_status->status_code === 'LA')
            {
                $dedication->propose()->first()->flowStatus()->create([
                    'item'        => $flow_status->item + 1,
                    'status_code' => 'UL', //Menunggu Luaran
                    'created_by'  => Auth::user()->nidn,
                ]);
            }
            $this->setOutputFlowStatuses($dedication);

        });

        return redirect()->intended($this->deleteUrl);
    }

    public function getFile($id, $type)
    {
//        dd($id . ' ' . $type);
        $dedication = Dedication::find($id);
        $propose = $dedication->propose()->first();
        $nidn = $propose->created_by;
        if ($type == 1)
        {
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/progress/' . $dedication->file_progress_activity);

            $this->storeDownloadLog($propose->id, 'progress activity', $dedication->file_progress_activity_ori, $dedication->file_progress_activity, $nidn);

            return response()->download($path, $dedication->file_progress_activity_ori, ['Content-Type' => 'application/pdf']);
        } elseif ($type == 2)
        {
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/progress/' . $dedication->file_progress_budgets);

            $this->storeDownloadLog($propose->id, 'progress budgets', $dedication->file_progress_budgets_ori, $dedication->file_progress_budgets, $nidn);

            return response()->download($path, $dedication->file_progress_budgets_ori, ['Content-Type' => 'application/pdf']);
        } elseif ($type == 3)
        {
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/final/' . $dedication->file_final_activity);

            $this->storeDownloadLog($propose->id, 'final activity', $dedication->file_final_activity_ori, $dedication->file_final_activity, $nidn);

            return response()->download($path, $dedication->file_final_activity_ori, ['Content-Type' => 'application/pdf']);
        } elseif ($type == 4)
        {
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/final/' . $dedication->file_final_budgets);

            $this->storeDownloadLog($propose->id, 'final budgets', $dedication->file_final_budgets_ori, $dedication->file_final_budgets, $nidn);

            return response()->download($path, $dedication->file_final_budgets_ori, ['Content-Type' => 'application/pdf']);
        }
    }

    public function output($id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $propose = $dedication->propose()->first();
        $propose_output_types = $propose->proposeOutputType()->get();

        $status_code = $propose->flowStatus()->orderBy('item', 'desc')->first()->status_code;

        $dedication_output_generals = $dedication->dedicationOutputGeneral()->get();
        if ($dedication_output_generals->isEmpty())
        {
            $dedication_output_generals = new Collection();
            foreach ($propose_output_types as $propose_output_type)
            {
                $dedication_output_general = new DedicationOutputGeneral();
                $dedication_output_general->output_description = $propose_output_type->outputType()->first()->output_name;
                $dedication_output_general->status = 'draft';
                $dedication_output_generals->add($dedication_output_general);
            }
        }

//        foreach ($propose_output_types as $propose_output_type)
//        {
//            $output_code = $propose_output_type->outputType()->first()->output_code;
//            if ($output_code === 'JS')
//            {
//                $dedication_output_services = $dedication->dedicationOutputService()->get();
//                if ($dedication_output_services->isEmpty())
//                {
//                    $dedication_output_services = new Collection();
//                    for ($i = 0; $i < 5; $i++)
//                    {
//                        $dedication_output_service = new DedicationOutputService();
//                        $dedication_output_services->add($dedication_output_service);
//                    }
//                }
//            } elseif ($output_code === 'MT')
//            {
//                $dedication_output_methods = $dedication->dedicationOutputMethod()->get();
//                $dedication_output_method = $dedication->dedicationOutputMethod()->first();
//                if ($dedication_output_method === null) $dedication_output_method = new DedicationOutputMethod();
//            } elseif ($output_code === 'PB')
//            {
//                $dedication_output_product = $dedication->dedicationOutputProduct()->first();
//                if ($dedication_output_product === null) $dedication_output_product = new DedicationOutputProduct();
//            } elseif ($output_code === 'PT')
//            {
//                $dedication_output_patent = $dedication->dedicationOutputPatent()->first();
//                if ($dedication_output_patent === null) $dedication_output_patent = new DedicationOutputPatent();
//            } elseif ($output_code === 'BP')
//            {
//                $dedication_output_guidebook = $dedication->dedicationOutputGuidebook()->first();
//                if ($dedication_output_guidebook === null) $dedication_output_guidebook = new DedicationOutputGuidebook();
//            }
//        }

        $dedication_output_revision = $dedication->dedicationOutputRevision()->orderBy('item', 'desc')->first();
        if ($dedication_output_revision === null) $dedication_output_revision = new DedicationOutputRevision();

        $disabled = '';
        $output_flow_status = $research->outputFlowStatus()->orderBy('id', 'desc')->first();
        $output_code = $output_flow_status->status_code;
        if ($output_flow_status !== null && ($output_code === 'VL' || $status_code === 'PS')) $disabled = 'disabled';
        $upd_mode = 'output';

        return view('dedication.dedication-output', compact(
            'dedication',
            'propose',
            'propose_output_types',
            'status_code',
            'output_code',
            'research_output_generals',
            'research_output_revision',
            'upd_mode',
            'disabled'
        ));
    }

    public function updateOutputGeneral(Requests\StoreOutputGeneralRequest $request, $id)
    {
        $research = Research::find($id);
        if ($research === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        DB::transaction(function () use ($research, $request)
        {
            $research_output_generals = $research->researchOutputGeneral()->get();
            $path = Storage::url('upload/' . md5($research->propose()->first()->created_by) . '/research-output/generals/');
            if ($request->delete_output !== null)
            {
                foreach ($request->delete_output as $key => $item)
                {
                    if ($item === '1')
                    {
                        $research_output_general = $research_output_generals->get($key);
                        if ($research_output_general !== null && $item !== null)
                        {
                            Storage::delete($path . $research_output_general->file_name);
                            $research_output_general->delete();
                        }
                    }
                }
            }

            foreach ($request->output_description as $key => $item)
            {
                $research_output_general = $research_output_generals->get($key);
                if ($request->file_name[$key] !== null)
                {
                    if ($research_output_general !== null && $item !== null)
                    {
                        Storage::delete($path . $research_output_general->file_name);
                    }
                    if ($research_output_general === null)
                    {
                        $research_output_general = new ResearchOutputGeneral();
                    }
                }
                $research_output_general->item = $key + 1;
                $research_output_general->output_description = $request->output_description[$key];
                $research_output_general->status = $request->status[$key];
                $research_output_general->url_address = $request->url_address[$key];
                if ($request->file_name[$key] !== null)
                {
                    $research_output_general->file_name_ori = $request->file('file_name')[$key]->getClientOriginalName();
                    $research_output_general->file_name = md5($request->file('file_name')[$key]->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $research->id . '.' . $request->file('file_name')[$key]->extension();
                    $request->file('file_name')[$key]->storeAs($path, $research_output_general->file_name);
                }
                $research->researchOutputGeneral()->save($research_output_general);

            }
            $this->setOutputFlowStatuses($research);
        });

        return redirect()->intended('researches');
    }

    public function updateOutputService(Requests\StoreOutputServiceRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        DB::transaction(function () use ($dedication, $request)
        {
            $dedication_output_services = $dedication->dedicationOutputService()->get();
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/dedication-output/services/');
            foreach ($request->file_name as $key => $item)
            {
                $dedication_output_service = $dedication_output_services->get($key);
                if ($dedication_output_service !== null)
                {
                    Storage::delete($path . $dedication_output_service->file_name);
                }
                if ($dedication_output_service === null)
                {
                    $dedication_output_service = new DedicationOutputService();
                }
                $dedication_output_service->item = $key + 1;
                $dedication_output_service->file_name_ori = $request->file('file_name')[$key]->getClientOriginalName();
                $dedication_output_service->file_name = md5($request->file('file_name')[$key]->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_name')[$key]->extension();
                $dedication->dedicationOutputService()->save($dedication_output_service);

                $request->file('file_name')[$key]->storeAs($path, $dedication_output_service->file_name);
            }
            $this->setFlowStatuses($dedication);
        });

        return redirect()->intended('dedications/' . $id . '/output');
    }

    public function updateOutputMethod(Requests\StoreOutputMethodRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        DB::transaction(function () use ($dedication, $request)
        {
            $dedication_output_method = $dedication->dedicationOutputMethod()->first();
            if ($dedication_output_method === null) $dedication_output_method = new DedicationOutputMethod();
            if ($request->file('file_name') !== null)
            {
                $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/dedication-output/methods/');
                if ($dedication_output_method->file_name !== null)
                {
                    Storage::delete($path . $dedication_output_method->file_name);
                }
                $dedication_output_method->file_name_ori = $request->file('file_name')->getClientOriginalName();
                $dedication_output_method->file_name = md5($request->file('file_name')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_name')->extension();
                $request->file('file_name')->storeAs($path, $dedication_output_method->file_name);
            }

            $dedication_output_method->item = 1;
            $dedication_output_method->annotation = $request->annotation;
            $dedication->dedicationOutputMethod()->save($dedication_output_method);

            $this->setFlowStatuses($dedication);
        });

        return redirect()->intended('dedications/' . $id . '/output');
    }

    public function updateOutputProduct(Requests\StoreOutputProductRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        DB::transaction(function () use ($dedication, $request)
        {
            $dedication_output_product = $dedication->dedicationOutputProduct()->first();
            if ($dedication_output_product === null) $dedication_output_product = new DedicationOutputProduct();
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/dedication-output/products/');
            if ($request->file('file_blueprint') !== null)
            {
                if ($dedication_output_product->file_blueprint !== null)
                {
                    Storage::delete($path . $dedication_output_product->file_blueprint);
                }
                $dedication_output_product->file_blueprint_ori = $request->file('file_blueprint')->getClientOriginalName();
                $dedication_output_product->file_blueprint = md5($request->file('file_blueprint')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_blueprint')->extension();
                $request->file('file_blueprint')->storeAs($path, $dedication_output_product->file_blueprint);
            }
            if ($request->file('file_finished_good') !== null)
            {
                if ($dedication_output_product->file_finished_good !== null)
                {
                    Storage::delete($path . $dedication_output_product->file_finished_good);
                }
                $dedication_output_product->file_finished_good_ori = $request->file('file_finished_good')->getClientOriginalName();
                $dedication_output_product->file_finished_good = md5($request->file('file_finished_good')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_finished_good')->extension();
                $request->file('file_finished_good')->storeAs($path, $dedication_output_product->file_finished_good);
            }
            if ($request->file('file_working_pic') !== null)
            {
                if ($dedication_output_product->file_working_pic !== null)
                {
                    Storage::delete($path . $dedication_output_product->file_working_pic);
                }
                $dedication_output_product->file_working_pic_ori = $request->file('file_working_pic')->getClientOriginalName();
                $dedication_output_product->file_working_pic = md5($request->file('file_working_pic')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_working_pic')->extension();
                $request->file('file_working_pic')->storeAs($path, $dedication_output_product->file_working_pic);
            }
            $dedication->dedicationOutputMethod()->save($dedication_output_product);

            $this->setFlowStatuses($dedication);
        });

        return redirect()->intended('dedications/' . $id . '/output');
    }

    public function updateOutputPatent(Requests\StoreOutputPatentRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        DB::transaction(function () use ($dedication, $request)
        {
            $dedication_output_patent = $dedication->dedicationOutputPatent()->first();
            if ($dedication_output_patent === null) $dedication_output_patent = new DedicationOutputPatent();
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/dedication-output/patents/');
            if ($request->file('file_patent') !== null)
            {
                if ($dedication_output_patent->file_patent !== null)
                {
                    Storage::delete($path . $dedication_output_patent->file_patent);
                }
                $dedication_output_patent->file_patent_ori = $request->file('file_patent')->getClientOriginalName();
                $dedication_output_patent->file_patent = md5($request->file('file_patent')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_patent')->extension();
                $request->file('file_patent')->storeAs($path, $dedication_output_patent->file_patent);
            }
            $dedication_output_patent->patent_no = $request->patent_no;
            $dedication_output_patent->patent_year = $request->patent_year;
            $dedication_output_patent->patent_owner_name = $request->patent_owner_name;
            $dedication_output_patent->patent_type = $request->patent_type;
            $dedication->dedicationOutputPatent()->save($dedication_output_patent);

            $this->setFlowStatuses($dedication);
        });

        return redirect()->intended('dedications/' . $id . '/output');
    }

    public function updateOutputGuidebook(Requests\StoreOutputGuidebookRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        DB::transaction(function () use ($dedication, $request)
        {
            $dedication_output_guidebook = $dedication->dedicationOutputGuidebook()->first();
            if ($dedication_output_guidebook === null) $dedication_output_guidebook = new DedicationOutputGuidebook();
            $path = Storage::url('upload/' . md5($dedication->propose()->first()->created_by) . '/dedication-output/guidebooks/');
            if ($request->file('file_cover') !== null)
            {
                if ($dedication_output_guidebook->file_cover !== null)
                {
                    Storage::delete($path . $dedication_output_guidebook->file_cover);
                }
                $dedication_output_guidebook->file_cover_ori = $request->file('file_cover')->getClientOriginalName();
                $dedication_output_guidebook->file_cover = md5($request->file('file_cover')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_cover')->extension();
                $request->file('file_cover')->storeAs($path, $dedication_output_guidebook->file_cover);
            }
            if ($request->file('file_back') !== null)
            {
                if ($dedication_output_guidebook->file_back !== null)
                {
                    Storage::delete($path . $dedication_output_guidebook->file_back);
                }
                $dedication_output_guidebook->file_back_ori = $request->file('file_back')->getClientOriginalName();
                $dedication_output_guidebook->file_back = md5($request->file('file_back')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_back')->extension();
                $request->file('file_back')->storeAs($path, $dedication_output_guidebook->file_back);
            }
            if ($request->file('file_table_of_contents') !== null)
            {
                if ($dedication_output_guidebook->file_table_of_contents !== null)
                {
                    Storage::delete($path . $dedication_output_guidebook->file_table_of_contents);
                }
                $dedication_output_guidebook->file_table_of_contents_ori = $request->file('file_table_of_contents')->getClientOriginalName();
                $dedication_output_guidebook->file_table_of_contents = md5($request->file('file_table_of_contents')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . $dedication->id . '.' . $request->file('file_table_of_contents')->extension();
                $request->file('file_table_of_contents')->storeAs($path, $dedication_output_guidebook->file_table_of_contents);
            }
            $dedication_output_guidebook->title = $request->title;
            $dedication_output_guidebook->book_year = $request->book_year;
            $dedication_output_guidebook->publisher = $request->publisher;
            $dedication_output_guidebook->isbn = $request->isbn;
            $dedication->dedicationOutputGuidebook()->save($dedication_output_guidebook);

            $this->setFlowStatuses($dedication);
        });

        return redirect()->intended('dedications/' . $id . '/output');
    }

    public function getOutputFile($id, $type, $subtype = 0)
    {
        if ($type == 1) //Service
        {
            $dedication_output_service = DedicationOutputService::find($id);
            if ($dedication_output_service === null)
            {
                $this->setCSS404();

                return abort('404');
            }
            $propose = $dedication_output_service->dedication()->first()->propose()->first();
            $nidn = $propose->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/dedication-output/services/' . $dedication_output_service->file_name);

            $this->storeDownloadLog($propose->id, 'output services', $dedication_output_service->file_name_ori, $dedication_output_service->file_name, $nidn);

            return response()->download($path, $dedication_output_service->file_name_ori, ['Content-Type' => 'images/jpeg']);
        } elseif ($type == 2) //Method
        {
            $dedication_output_method = DedicationOutputMethod::find($id);
            if ($dedication_output_method === null)
            {
                $this->setCSS404();

                return abort('404');
            }
            $propose = $dedication_output_method->dedication()->first()->propose()->first();
            $nidn = $propose->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/dedication-output/methods/' . $dedication_output_method->file_name);

            $this->storeDownloadLog($propose->id, 'output methods', $dedication_output_method->file_name_ori, $dedication_output_method->file_name, $nidn);

            return response()->download($path, $dedication_output_method->file_name_ori, []);
        } elseif ($type == 3) //Product
        {
            $dedication_output_product = DedicationOutputProduct::find($id);
            if ($dedication_output_product === null)
            {
                $this->setCSS404();

                return abort('404');
            }
            $propose = $dedication_output_product->dedication()->first()->propose()->first();
            $nidn = $propose->created_by;
            if ($subtype == 1)
            {
                $file_ori = $dedication_output_product->file_blueprint_ori;
                $file = $dedication_output_product->file_blueprint;
                $this->storeDownloadLog($propose->id, 'output products blueprint', $dedication_output_product->file_blueprint_ori, $dedication_output_product->file_blueprint, $nidn);
            } elseif ($subtype == 2)
            {
                $file_ori = $dedication_output_product->file_finished_good_ori;
                $file = $dedication_output_product->file_finished_good;
                $this->storeDownloadLog($propose->id, 'output products FG', $dedication_output_product->file_finished_good_ori, $dedication_output_product->file_finished_good, $nidn);
            } elseif ($subtype == 3)
            {
                $file_ori = $dedication_output_product->file_working_pic_ori;
                $file = $dedication_output_product->file_working_pic;
                $this->storeDownloadLog($propose->id, 'output products WP', $dedication_output_product->file_working_pic_ori, $dedication_output_product->file_working_pic, $nidn);
            }

            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/dedication-output/products/' . $file);

            return response()->download($path, $file_ori, []);
        } elseif ($type == 4) //Patent
        {
            $dedication_output_patent = DedicationOutputPatent::find($id);
            if ($dedication_output_patent === null)
            {
                $this->setCSS404();

                return abort('404');
            }
            $propose = $dedication_output_patent->dedication()->first()->propose()->first();
            $nidn = $propose->created_by;
            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/dedication-output/patents/' . $dedication_output_patent->file_patent);

            $this->storeDownloadLog($propose->id, 'output patents', $dedication_output_patent->file_patent_ori, $dedication_output_patent->file_patent, $nidn);

            return response()->download($path, $dedication_output_patent->file_patent_ori, []);
        } elseif ($type == 5) //Guidebook
        {
            $dedication_output_guidebook = DedicationOutputGuidebook::find($id);
            if ($dedication_output_guidebook === null)
            {
                $this->setCSS404();

                return abort('404');
            }
            $propose = $dedication_output_guidebook->dedication()->first()->propose()->first();
            $nidn = $propose->created_by;
            if ($subtype == 1)
            {
                $file_ori = $dedication_output_guidebook->file_cover_ori;
                $file = $dedication_output_guidebook->file_cover;
                $this->storeDownloadLog($propose->id, 'output guidebooks', $dedication_output_guidebook->file_cover_ori, $dedication_output_guidebook->file_cover, $nidn);
            } elseif ($subtype == 2)
            {
                $file_ori = $dedication_output_guidebook->file_back_ori;
                $file = $dedication_output_guidebook->file_back;
                $this->storeDownloadLog($propose->id, 'output guidebooks', $dedication_output_guidebook->file_back_ori, $dedication_output_guidebook->file_back, $nidn);
            } elseif ($subtype == 3)
            {
                $file_ori = $dedication_output_guidebook->file_table_of_contents_ori;
                $file = $dedication_output_guidebook->file_table_of_contents;
                $this->storeDownloadLog($propose->id, 'output guidebooks', $dedication_output_guidebook->file_table_of_contents_ori, $dedication_output_guidebook->file_table_of_contents, $nidn);
            }

            $path = storage_path() . '/app' . Storage::url('upload/' . md5($nidn) . '/dedication-output/guidebooks/' . $file);

            return response()->download($path, $file_ori, []);
        }
    }

    public function approveList()
    {
        $periods = Period::all();

        $period = new Period();
        $period->id = '0';
        $period->scheme = 'Mandiri';
        $periods->add($period);

        $period = $periods[0];

        return view('dedication.dedication-approve-list', compact(
            'periods',
            'period'
        ));
    }

    public function approveDetail($id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $propose = $dedication->propose()->first();
        $propose_output_types = $propose->proposeOutputType()->get();
        
        $status_code = $propose->flowStatus()->orderBy('item', 'desc')->first()->status_code;
        $output_code = $dedication->outputFlowStatus()->orderBy('id', 'desc')->first()->status_code;

        $dedication_output_generals = $dedication->dedicationOutputGeneral()->get();
        if ($dedication_output_generals->isEmpty())
        {
            $this->setCSS404();

            return abort('404');
        }

//        foreach ($propose_output_types as $propose_output_type)
//        {
//            $output_code = $propose_output_type->outputType()->first()->output_code;
//            if ($output_code === 'JS')
//            {
//                $dedication_output_services = $dedication->dedicationOutputService()->get();
//                if ($dedication_output_services->isEmpty())
//                {
//                    $dedication_output_services = new Collection();
//                    for ($i = 0; $i < 5; $i++)
//                    {
//                        $dedication_output_service = new DedicationOutputService();
//                        $dedication_output_services->add($dedication_output_service);
//                    }
//                }
//            } elseif ($output_code === 'MT')
//            {
//                $dedication_output_methods = $dedication->dedicationOutputMethod()->get();
//                $dedication_output_method = $dedication->dedicationOutputMethod()->first();
//                if ($dedication_output_method === null) $dedication_output_method = new DedicationOutputMethod();
//            } elseif ($output_code === 'PB')
//            {
//                $dedication_output_product = $dedication->dedicationOutputProduct()->first();
//                if ($dedication_output_product === null) $dedication_output_product = new DedicationOutputProduct();
//            } elseif ($output_code === 'PT')
//            {
//                $dedication_output_patent = $dedication->dedicationOutputPatent()->first();
//                if ($dedication_output_patent === null) $dedication_output_patent = new DedicationOutputPatent();
//            } elseif ($output_code === 'BP')
//            {
//                $dedication_output_guidebook = $dedication->dedicationOutputGuidebook()->first();
//                if ($dedication_output_guidebook === null) $dedication_output_guidebook = new DedicationOutputGuidebook();
//            }
//        }

        $dedication_output_revision = $dedication->dedicationOutputRevision()->orderBy('item', 'desc')->first();
        if ($dedication_output_revision === null || $output_code === 'VL') $dedication_output_revision = new DedicationOutputRevision();

        $disabled = 'disabled';
        $upd_mode = 'approve';

        return view('dedication.dedication-output', compact(
            'dedication',
            'propose',
            'status_code',
            'propose_output_types',
            'dedication_output_services',
            'dedication_output_methods',
            'dedication_output_method',
            'dedication_output_product',
            'dedication_output_patent',
            'dedication_output_guidebook',
            'dedication_output_revision',
            'upd_mode',
            'disabled'
        ));


        $dedication = Dedication::find($id);

        return view('dedication.dedication-approve-detail');
    }

    public function approveUpdate(Requests\StoreApproveDedicationRequest $request, $id)
    {
        $dedication = Dedication::find($id);
        if ($dedication === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        DB::transaction(function () use ($request, $dedication)
        {
            $flow_status = $dedication->propose()->first()->flowStatus()->orderBy('item', 'desc')->first();
            if ($request->is_approved === 'no')
            {
                $dedication_output_revision = $dedication->dedicationOutputRevision()->orderBy('item', 'desc')->first();
                if ($dedication_output_revision === null)
                {
                    $dedication_output_revision = new DedicationOutputRevision();
                    $dedication_output_revision->item = 0;
                }

                $dedication_output_revision->revision_text = $request->revision_text;
                if ($flow_status->status_code === 'RL')
                {
                    $dedication_output_revision->updated_by = Auth::user()->nidn;
                    $dedication_output_revision->save();
                } else
                {
                    $dedication_output_revision->created_by = Auth::user()->nidn;
                    $dedication_output_revision->item = $dedication_output_revision->item + 1;
                    $dedication->dedicationOutputRevision()->save($dedication_output_revision);
                    $dedication->propose()->first()->flowStatus()->create([
                        'item'        => $flow_status->item + 1,
                        'status_code' => 'RL', // Revisi Luaran,
                        'created_by'  => Auth::user()->nidn
                    ]);

                    $this->setEmail('RL', $research->propose()->first());
                }
            } else
            {
                $dedication->outputFlowStatus()->create([
                    'item'        => $flow_status->item + 1,
                    'status_code' => 'LT', // Validasi Luaran Diterima
                    'created_by'  => Auth::user()->nidn
                ]);
                $dedication->propose()->first()->flowStatus()->create([
                    'item'        => $flow_status->item + 1,
                    'status_code' => 'PS', // Pengabdian Selesai,
                    'created_by'  => Auth::user()->nidn
                ]);
                $this->setEmail('PS', $research->propose()->first());
            }
        });

        return redirect()->intended($this->deleteUrl . '/approve-list');
    }

    private function setFlowStatuses($dedication)
    {
        $flow_status = $dedication->propose()->first()->flowStatus()->orderBy('item', 'desc')->first();
        if ($flow_status->status_code === 'UL' || $flow_status->status_code === 'RL')
        {
            $dedication->propose()->first()->flowStatus()->create([
                'item'        => $flow_status->item + 1,
                'status_code' => 'VL', //Menunggu Validasi Luaran
                'created_by'  => Auth::user()->nidn,
            ]);
        }
    }

    private function setOutputFlowStatuses($dedication)
    {
        $output_flow_status = $dedication->outputFlowStatus()->orderBy('id', 'desc')->first();
        if ($output_flow_status === null)
        {
            $output_flow_status = new OutputFlowStatus();
        }

        $continue_output_flow = true;
        $dedication_output_generals = $dedication->dedicationOutputGeneral()->get();
        if ($dedication_output_generals->isEmpty())
        {
            $continue_output_flow = false;
        }
        foreach ($dedication_output_generals as $dedication_output_general)
        {
            if ($dedication_output_general->status == 'draft' ||
                $dedication_output_general->status == 'submitted' ||
                $dedication_output_general->status == 'accepted'
            )
            {
                $continue_output_flow = false;
                break;
            }
        }

        if ($continue_output_flow || $output_flow_status->status_code === 'RL')
        {
            $dedication->outputFlowStatus()->create([
                'item'        => $output_flow_status->item + 1,
                'status_code' => 'VL', //Menunggu Validasi Luaran
                'created_by'  => Auth::user()->nidn,
            ]);

            $this->setEmail('RL', $dedication->propose()->first());
        }
        if ($output_flow_status->status_code === 'LT')
        {
            $flow_status = $dedication->propose()->first()->flowStatus()->orderBy('id', 'desc')->first();
            $dedication->propose()->first()->flowStatus()->create([
                'item'        => $flow_status->item + 1,
                'status_code' => 'PS', //Pengabdian Selesai
                'created_by'  => Auth::user()->nidn,
            ]);
            $this->setEmail('PS', $dedication->propose()->first());
        }
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
