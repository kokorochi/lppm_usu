<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApproveDedicationRequest extends FormRequest {
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
            'is_approved' => 'required',
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
        if ($this->is_approved === 'no' &&
            ($this->revision_text === null || $this->revision_text === '')
        )
        {
            array_push($ret, 'Alasan Perbaikan harus diisi');
        }
        return $ret;
    }
}
