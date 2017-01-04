<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewer extends FormRequest {
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
            'full_name'  => 'required',
            'nidn'       => 'required|numeric',
            'begin_date' => 'required',
            'end_date'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required'  => 'Nama harus diisi',
            'nidn.required'       => 'Pemilihan dosen harus dilakukan via autocomplete',
            'begin_date.required' => 'Tanggal mulai harus diisi',
            'end_date.required'   => 'Tanggal akhir harus diisi',
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
        if (strtotime($this->input('begin_date')) > strtotime($this->input('end_date')))
        {
            array_push($ret, 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
        }

        $user = User::where('nidn', $this->input('nidn'))->first();
        if ($user === null)
        {
            array_push($ret, 'Dosen ini belum menjadi user pada sistem LPPM');
        } else
        {
            if ($user->auths()->where('auth_object_ref_id', '3')->exists())
            {
                $pos = strpos($this->url(), 'edit');
                if ($pos === false)
                {
                    array_push($ret, 'User ini sudah menjadi reviewer');
                }
            }
        }

        return $ret;
    }
}
