<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResetPasswordRequest extends FormRequest {
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
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'password.required'  => 'Password tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min'       => 'Password minimal 6 karakter',
        ];
    }
}
