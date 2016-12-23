<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppraisalRequest extends FormRequest {
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
            'name'      => 'required',
            'aspect.*'  => 'required',
            'quality.*' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => 'Nama aspek penilaian harus diisi',
            'aspect.*.required'  => 'Deskripsi aspek penilaian harus diisi',
            'quality.*.required' => 'Bobot harus diisi',
            'quality.*.integer'  => 'Bobot harus merupakan angka',
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator)
        {
            // Call the after method of the FormRequest (see below)
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        if (! $this->checkTotalQuality())
        {
            $validator->errors()->add('countQuality', 'Total bobot harus bernilai = 100');
        }
    }

    private function checkTotalQuality()
    {
        $countQuality = 0;
        foreach ($this->input('quality') as $quality)
        {
            $countQuality += $quality;
        }

        return $countQuality === 100;
    }
}
