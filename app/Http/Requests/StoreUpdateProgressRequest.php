<?php

namespace App\Http\Requests;

use App\Dedication;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProgressRequest extends FormRequest {
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
            'file_progress_activity' => 'required|mimes:pdf',
            'file_progress_budgets'  => 'required|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'file_progress_activity.required' => 'Laporan Kemajuan (Kegiatan) harus diisi',
            'file_progress_budgets.required'  => 'Laporan Kemajuan (Anggaran) harus diisi',
            'file_progress_activity.mimes'    => 'Laporan Kemajuan (Kegiatan) harus dalam bentuk PDF',
            'file_progress_budgets.mimes'     => 'Laporan Kemajuan (Anggaran) harus dalam bentuk PDF',
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

        $period = Dedication::find($this->id)->propose()->first()->period()->first();
        $today_date = Carbon::now()->toDateString();

        if (! ($today_date >= $period->first_begda && $today_date <= $period->first_endda))
        {
            array_push($ret, 'Tidak dalam masa update Laporan Kemajuan');
        }

        return $ret;
    }
}
