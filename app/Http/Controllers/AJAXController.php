<?php

namespace App\Http\Controllers;

use App\Auths;
use App\ModelSDM\Lecturer;
use App\Period;
use App\Propose;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AJAXController extends BlankonController {
    public function __construct()
    {
        parent::__construct();
    }

    public function getPeriod()
    {
        $period_id = Input::get('period_id');

        $period = Period::find($period_id);
        $period->category_name = $period->categoryType->category_name;
        $period->dedication_name = $period->dedicationType->dedication_name;

        $period = json_encode($period, JSON_PRETTY_PRINT);

        return response($period, 200)->header('Content-Type', 'application/json');
    }

    public function searchLecturer()
    {
        $input = '%' . Input::get("key_input") . '%';
        $lecturers = Lecturer::where('full_name', 'LIKE', $input)
            ->orWhere('employee_card_serial_number', 'LIKE', $input)->take(10)->get();

        foreach ($lecturers as $lecturer)
        {
            $lecturer->full_name = $lecturer->employee_card_serial_number . ' : ' . $lecturer->full_name;
        }

        $lecturers = json_encode($lecturers, JSON_PRETTY_PRINT);

        return response($lecturers, 200)->header('Content-Type', 'application/json');
    }

    public function getLecturerByNIDN()
    {
        $input = Input::get("key_input");
        $lecturer = Lecturer::where('employee_card_serial_number', $input)->first();


//        return json_encode($lecturer, JSON_PRETTY_PRINT);
        $lecturer = json_encode($lecturer, JSON_PRETTY_PRINT);

//
        return response($lecturer, 200)->header('Content-Type', 'application/json');
    }

    public function getProposesByScheme()
    {
        $period_id = Input::get("period_id");
        $status_codes = Input::get("status_code");
        $type = Input::get("type");
        if ($period_id == 0)
        {
            $proposes = Propose::where('is_own', '1')->get();
        } else
        {
            $period = Period::find($period_id);
            $proposes = $period->propose()->get();
        }
        $proposes_final = new Collection;
        foreach ($proposes as $propose)
        {
            $status_code = $propose->flowStatus()->orderBy('item', 'desc')->first()->status_code;
            $propose->status_code = $status_code;
            if ($status_codes !== null)
            {
                foreach ($status_codes as $item)
                {
                    if ($status_code === $item)
                    {
                        $proposes_final->add($propose);
                    }
                }
            } else
            {
                if ($status_code !== 'SS') //Skip if status is Simpan Sementara
                {
                    $proposes_final->add($propose);
                }
            }
        }

        $i = 0;
        $data = [];
        foreach ($proposes_final as $propose)
        {
            $data['data'][$i][0] = $propose->title;
            $data['data'][$i][1] = Lecturer::where('employee_card_serial_number', $propose->created_by)->first()->full_name;
            if ($propose->is_own === '1')
            {
                $data['data'][$i][2] = $propose->proposesOwn()->first()->scheme;
            } else
            {
                $data['data'][$i][2] = $period->scheme;
            }
            $data['data'][$i][3] = $propose->flowStatus()->orderBy('item', 'desc')->first()->statusCode()->first()->description;
            if ($type === 'ASSIGN')
            {
                $data['data'][$i][4] = '<td class="text-center"><a href="' . url('reviewers/assign', $propose->id) . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Assign"><i class="fa fa-plus-circle"></i></a></td>';
            } elseif ($type === 'APPROVE')
            {
                if ($propose->status_code === 'RS')
                {
                    $data['data'][$i][4] = '<td class="text-center"><a href="' . url('approve-proposes', $propose->id) . '/approve' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Approve"><i class="fa fa-check-square-o"></i></a></td>';
                } else
                {
                    $data['data'][$i][4] = '<td class="text-center"><a href="' . url('approve-proposes', $propose->id) . '/display' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Detail"><i class="fa fa-search-plus"></i></a></td>';
                }
            }

            $i++;
        }
        $count_data = count($data);
        if ($count_data == 0)
        {
            $data['data'] = [];
        }
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $count_data;
        $data = json_encode($data, JSON_PRETTY_PRINT);

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    public function getReviewer()
    {
//        $key_input = Input::get('key_input');
        $reviewers = Auths::where('auth_object_ref_id', '3')->get();
        $i = 0;
        foreach ($reviewers as $reviewer)
        {
            $lecturer = $reviewer->user()->first()->lecturer()->first();
            $data[$i]['nidn'] = $lecturer->employee_card_serial_number;
            $data[$i]['full_name'] = $lecturer->full_name;
            $i++;
        }
        $data = json_encode($data, JSON_PRETTY_PRINT);

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    public function searchReviewer()
    {
        $input = Input::get("key_input");
        $reviewers = Auths::where('auth_object_ref_id', '3')->get();
        $i = 0;
        $data = [];
        foreach ($reviewers as $reviewer)
        {
            $lecturer = $reviewer->user()->first()->lecturer()->first();
            if (stripos($lecturer->full_name, $input) !== false ||
                stripos($lecturer->employee_card_serial_number, $input) !== false
            )
            {
                $data[$i]['nidn'] = $lecturer->employee_card_serial_number;
                $data[$i]['full_name'] = $lecturer->full_name;
                $i++;
            }
        }
        $data = json_encode($data, JSON_PRETTY_PRINT);

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    public function getDedication()
    {
        $period_id = Input::get("period_id");
        $review_by = Input::get("review_by");
        if ($period_id == 0)
        {
            $proposes = Propose::where('is_own', '1')->get();
        } else
        {
            $period = Period::find($period_id);
            $proposes = $period->propose()->get();
        }

        $dedications = new Collection();
        foreach ($proposes as $propose)
        {
            $dedication = $propose->dedication()->first();
            if ($dedication !== null)
            {
                if ($review_by !== null)
                {
                    $dedication_reviewer = $propose->dedicationReviewer()->where('nidn', $review_by)->first();
                    if ($dedication_reviewer !== null)
                    {
                        $dedications->add($dedication);
                    }
                } else
                {
                    $dedications->add($dedication);
                }
            }
        }

        $i = 0;
        $data = [];
        foreach ($dedications as $dedication)
        {
            $propose = $dedication->propose()->first();
            $data['data'][$i][0] = $propose->title;
            $data['data'][$i][1] = Lecturer::where('employee_card_serial_number', $propose->created_by)->first()->full_name;
            if ($propose->is_own === '1')
            {
                $data['data'][$i][2] = $propose->proposesOwn()->first()->scheme;
            } else
            {
                $data['data'][$i][2] = $period->scheme;
            }
            $data['data'][$i][3] = $propose->flowStatus()->orderBy('item', 'desc')->first()->statusCode()->first()->description;
            if ($review_by === null)
            {
                $data['data'][$i][4] = '<td class="text-center"><a href="' . url('dedications', $dedication->id) . '/approve' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Approve"><i class="fa fa-check-square-o"></i></a></td>';
            } else
            {
                $data['data'][$i][4] = '<td class="text-center"><a href="' . url('review-proposes', $dedication->id) . '/dedication-display' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Display"><i class="fa fa-search-plus"></i></a></td>';
            }
            $i++;
        }
        $count_data = count($data);
        if ($count_data == 0)
        {
            $data['data'] = [];
        }
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $count_data;
        $data = json_encode($data, JSON_PRETTY_PRINT);

        return response($data, 200)->header('Content-Type', 'application/json');
    }
}