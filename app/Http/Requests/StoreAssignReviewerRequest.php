<?php

namespace App\Http\Requests;

use App\Propose;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssignReviewerRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display.*' => 'required',
            'nidn.*'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'display.*' => 'Nama reviewer harus diisi',
            'nidn.*'    => 'Pemilihan reviewer harus dilakukan menggunakan autocomplete'
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator)
        {
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        $check = $this->checkBeforeSave();
        if (count($check) > 0)
        {
            foreach ($check as $item)
            {
                $validator->errors()->add('sumErrors', $item);
            }
        }
    }

    private function checkBeforeSave()
    {
        $ret = [];
        $propose = Propose::find($this->id);
        $members = $propose->member()->get();
        foreach ($this->input('nidn') as $item)
        {
            $member = $members->where('nidn', $item)->first();
            if ($member !== null || $propose->created_by === $item)
            {
                array_push($ret, 'Reviewer yang dipilih tidak boleh merupakan ketua/anggota pada proposal ini');
                break;
            }
        }

        //Check Duplicate Reviewer
        $member_collection = $this->input('nidn');
        $member_collection = array_unique($member_collection);
        if (count($member_collection) !== ( count($this->input('nidn'))))
        {
            array_push($ret, 'Reviewer yang dipilih tidak boleh duplikasi');
        }

        $flow_status = $propose->flowStatus()->orderBy('item', 'desc')->first();
        if ($flow_status->status_code !== 'MR' &&
            $flow_status->status_code !== 'PR')
        {
            array_push($ret, 'Penentuan reviewer hanya dapat dilakukan untuk proposal dengan status "Penetuan Reviewer" atau "Menunggu Untuk Direview" saja');
        }

        return $ret;
    }
}
