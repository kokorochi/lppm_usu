<?php

namespace App\Http\Requests;

use App\Category_type;
use App\Dedication_type;
use App\Appraisal;
use Illuminate\Foundation\Http\FormRequest;


class StorePeriodRequest extends FormRequest {
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
            'years'           => 'required|date_format:Y',
            'category_type'   => 'required',
            'dedication_type' => 'required',
            'appraisal_type'  => 'required',
            'scheme'          => 'required|max:255',
            'sponsor'         => 'required|max:255',
            'min_member'      => 'required|numeric',
            'max_member'      => 'required|numeric',
            'propose_begda'   => 'required|date',
            'propose_endda'   => 'required|date',
            'review_begda'    => 'required|date',
            'review_endda'    => 'required|date',
            'first_begda'     => 'required|date',
            'first_endda'     => 'required|date',
            'monev_begda'     => 'required|date',
            'monev_endda'     => 'required|date',
            'last_begda'      => 'required|date',
            'last_endda'      => 'required|date',
            'total_amount'    => 'required',
            'score'           => 'required',
            'annotation'      => '',
        ];
    }

    public function messages()
    {
        return [
            'years.required'           => 'Tahun harus diisi',
            'years.date_format'        => 'Tahun harus sesuai dengan format tahun',
            'category_type.required'   => 'Jenis Sumber Dana harus diisi',
            'dedication_type.required' => 'Jenis Pengabdian harus diisi',
            'appraisal_type.required'  => 'Jenis Penilaian harus diisi',
            'scheme.required'          => 'Scheme harus diisi',
            'scheme.max'               => 'Maksimal 255 karakter untuk Scheme',
            'sponsor.required'         => 'Sumber Dana harus diisi',
            'sponsor.max'              => 'Maksimal 255 karakter untuk sumber dana',
            'min_member.required'      => 'Anggota minimal harus diiisi',
            'min_member.numeric'       => 'Anggota harus dalam angka',
            'max_member.required'      => 'Anggota maksimal harus diiisi',
            'max_member.numeric'       => 'Anggota harus dalam angka',
            'propose_begda.required'   => 'Periode usulan harus diisi',
            'propose_begda.date'       => 'Periode usulan harus sesuai dengan format tanggal',
            'propose_endda.required'   => 'Periode usulan harus diisi',
            'propose_endda.date'       => 'Periode usulan harus sesuai dengan format tanggal',
            'review_begda.required'    => 'Periode review harus diisi',
            'review_begda.date'        => 'Periode review harus sesuai dengan format tanggal',
            'review_endda.required'    => 'Periode review harus diisi',
            'review_endda.date'        => 'Periode review harus sesuai dengan format tanggal',
            'first_begda.required'     => 'Periode laporan kemajuan harus diisi',
            'first_begda.date'         => 'Periode laporan kemajuan harus sesuai dengan format tanggal',
            'first_endda.required'     => 'Periode laporan kemajuan harus diisi',
            'first_endda.date'         => 'Periode laporan kemajuan harus sesuai dengan format tanggal',
            'monev_begda.required'     => 'Periode monev harus diisi',
            'monev_begda.date'         => 'Periode monev harus sesuai dengan format tanggal',
            'monev_endda.required'     => 'Periode monev harus diisi',
            'monev_endda.date'         => 'Periode monev harus sesuai dengan format tanggal',
            'last_begda.required'      => 'Periode laporan akhir harus diisi',
            'last_begda.date'          => 'Periode laporan akhir harus sesuai dengan format tanggal',
            'last_endda.required'      => 'Periode laporan akhir harus diisi',
            'last_endda.date'          => 'Periode laporan akhir harus sesuai dengan format tanggal',
            'total_amount.required'    => 'Jumlah dana maksimal harus diisi',
            'score.required'           => 'Skor minimal harus diisi',
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
        if ($check !== '')
        {
            $validator->errors()->add('sumErrors', $check);
        }
    }

    private function checkBeforeSave()
    {
        if (! $this->checkCategoryType())
        {
            return 'Pilihan kategori tidak ditemukan';
        }
        if (! $this->checkDedicationType())
        {
            return 'Pilihan jenis pengabdian tidak ditemukan';
        }
        if (! $this->checkAppraisalType())
        {
            return 'Pilihan jenis aspek penilaian tidak ditemukan';
        }

        return '';
    }

    private function checkCategoryType()
    {
        return Category_type::where('id', $this->input('category_type'))->exists();
    }

    private function checkDedicationType()
    {
        return Dedication_type::where('id', $this->input('dedication_type'))->exists();
    }

    private function checkAppraisalType()
    {
        return Appraisal::where('id', $this->input('appraisal_type'))->exists();
    }
}
