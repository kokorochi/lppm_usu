<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest {
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
            'nidn'     => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nidn.required'     => 'NIDN harus diisi',
            'password.required' => 'Password harus diisi',
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
        if ($this->nidn === '' || $this->password === '') return $ret;

        $user = User::where('nidn', $this->nidn)->first();
        if ($user !== null)
        {
            if (strlen($user->password) === 40)
            {
                $pass_sha1 = sha1($this->password);
                if ($pass_sha1 === $user->password)
                {
                    // Login Success For First Time User, Change the user password to bcrypt
                    $user->password = bcrypt($this->password);
                    $user->save();
                    $user->auths()->create([
                        'auth_object_ref_id' => '4',
                        'begin_date'         => '2000-01-01',
                        'end_date'           => '9999-12-31',
                        'created_by'         => 'admin',
                    ]);
                }
            }
        }

        if (! (Auth::attempt(['nidn' => $this->nidn, 'password' => $this->password], $this->remember_me)))
        {
            array_push($ret, 'NIDN / Password yang dimasukkan salah');
        }

        return $ret;
    }
}
