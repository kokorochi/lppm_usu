<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateVerificationRequest extends FormRequest {
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
            foreach ($check as $key => $item)
            {
                $validator->errors()->add('member_areas_of_expertise.' . $key, $item);
            }
        }
    }

    public function checkBeforeSave()
    {
        $ret = [];

        foreach ($this->input('member_areas_of_expertise') as $item)
        {
            if ($item === null || $item === '')
            {
                foreach ($this->input('member_nidn') as $key => $item_2)
                {
                    if ($item_2 === Auth::user()->nidn)
                    {
                        $ret[$key] = 'Bidang Kealihan harus diisi';
                    }
                }
            }
        }

        return $ret;
    }
}
