<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutputServiceRequest extends FormRequest {
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
            'file_name.0' => 'required',
            'file_name.1' => 'required',
            'file_name.2' => 'required',
            'file_name.3' => 'required',
            'file_name.4' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'file_name.*.required' => 'Dokumentasi harus diisi',
        ];
    }
}
