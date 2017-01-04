<?php

namespace App\Http\Requests;

use App\Dedication;
use Illuminate\Foundation\Http\FormRequest;

class StoreOutputPatentRequest extends FormRequest {
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
            'patent_no'         => 'required',
            'patent_year'       => 'required|date_format:Y',
            'patent_owner_name' => 'required',
            'patent_type'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'patent_no.required'         => 'Nomor SK Paten harus diisi',
            'patent_year.required'       => 'Tahun Paten harus diisi',
            'patent_year.date_format:Y'  => 'Tahun Paten harus dalam format tahun',
            'patent_owner_name.required' => 'Nomor Pemilik Paten harus diisi',
            'patent_type.required'       => 'Jenis Paten harus diisi',
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
        $dedication = Dedication::find($this->id);
        $dedication_output_patent = $dedication->dedicationOutputPatent()->first();
        if ($dedication_output_patent === null)
        {
            if ($this->file('file_patent') === null)
            {
                array_push($ret, 'Sertifikat Paten harus diunggah');
            }
        }

        return $ret;
    }
}
