<?php

namespace App\Http\Requests;

use App\Dedication;
use App\DedicationOutputMethod;
use Illuminate\Foundation\Http\FormRequest;

class StoreOutputMethodRequest extends FormRequest
{
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
            'annotation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'annotation.required' => 'Keterangan harus diisi'
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
        $dedication_output_method = $dedication->dedicationOutputMethod()->first();
        if($dedication_output_method === null)
        {
            if($this->file('file_name') === null)
            {
                array_push($ret, 'Dokumen harus diunggah');
            }
        }
        return $ret;
    }
}
