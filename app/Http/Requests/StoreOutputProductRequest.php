<?php

namespace App\Http\Requests;

use App\Dedication;
use Illuminate\Foundation\Http\FormRequest;

class StoreOutputProductRequest extends FormRequest {
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
        $dedication_output_product = $dedication->dedicationOutputProduct()->first();
        if ($dedication_output_product === null)
        {
            if ($this->file('file_blueprint') === null)
            {
                array_push($ret, 'Blueprint harus diisi dan diunggah');
            }
            if ($this->file('file_finished_good') === null)
            {
                array_push($ret, 'Barang Jadi harus diisi dan diunggah');
            }
            if ($this->file('file_working_pic') === null)
            {
                array_push($ret, 'Gambar Kerja harus diisi dan diunggah');
            }
        }

        return $ret;
    }
}
