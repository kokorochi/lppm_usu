<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProposeRequest extends FormRequest {
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
            'file_propose' => 'required|mimes:pdf'
        ];
    }

    public function messages()
    {
        return [
            'file_propose.required' => 'Usulan harus diunggah',
            'file_propose.mimes'    => 'Usulan harus dalam bentuk PDF'
        ];
    }
}
