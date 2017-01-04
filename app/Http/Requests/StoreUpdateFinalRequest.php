<?php

namespace App\Http\Requests;

use App\Dedication;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateFinalRequest extends FormRequest {
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
            'file_final_activity' => 'required|mimes:pdf',
            'file_final_budgets'  => 'required|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'file_final_activity.required' => 'Laporan Akhir (Kegiatan) harus diisi',
            'file_final_budgets.required'  => 'Laporan Akhir (Anggaran) harus diisi',
            'file_final_activity.mimes'    => 'Laporan Akhir (Kegiatan) harus dalam bentuk PDF',
            'file_final_budgets.mimes'     => 'Laporan Akhir (Anggaran) harus dalam bentuk PDF',
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

        if ($period->last_begda > $today_date || $period->last_endda < $today_date)
        {
            array_push($ret, 'Tidak dalam masa update Laporan Akhir');
        }

        return $ret;
    }
}
