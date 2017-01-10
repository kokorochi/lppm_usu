<?php

namespace App\Http\Requests;

use App\ModelSDM\Faculty;
use App\ModelSDM\Lecturer;
use App\Output_type;
use App\Period;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProposeRequest extends FormRequest {
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
            //Check Dedication Partner
            'partner_name.*'          => 'required',
            'partner_territory.*'     => 'required',
            'partner_city.*'          => 'required',
            'partner_province.*'      => 'required',
            'partner_distance.*'      => 'required',
            'file_partner_contract.*' => 'required|mimes:pdf',

            'own-years'          => 'numeric',
            'own-member'         => 'numeric',
            //End Check Dedication Partner

            //Check Member
            'member_display.*'   => 'required',
            'member_nidn.*'      => 'required',
            //End Check Member

            //Check Detail
            'faculty_code'       => 'required',
            'title'              => 'required|max:100',
            'total_amount'       => 'required',
            'areas_of_expertise' => 'required',
            'time_period'        => 'required|max:2',
            'address'            => 'required',
            //End Check Detail

            //Check Upload
//            'file_partner_contract' => 'required|mimes:pdf',
            'file_propose'       => 'mimes:pdf',
            'file_propose_final' => 'mimes:pdf'
            //End Check Detail
        ];
    }

    public function messages()
    {
        return [
            'partner_name.*.required'      => 'Nama partner tidak boleh kosong',
            'partner_territory.*.required' => 'Wilayah Mitra (Desa/Kecamatan) tidak boleh kosong',
            'partner_city.*.required'      => 'Kabupaten/Kota tidak boleh kosong',
            'partner_province.*.required'  => 'Provinsi tidak boleh kosong',
            'partner_distance.*.required'  => 'Jarak PT ke lokasi mitra (KM) tidak boleh kosong',

            'member_display.*.required' => 'Nama Anggota tidak boleh kosong',
            'member_nidn.*.required'    => 'NIDN Anggota tidak boleh kosong',

            'faculty_code.required'       => 'Fakultas tidak boleh kosong',
            'title.required'              => 'Judul Pengabdian tidak boleh kosong',
            'output_type.required'        => 'Luaran tidak boleh kosong',
            'total_amount.required'       => 'Jumlah Dana tidak boleh kosong',
            'time_period.required'        => 'Jangka Waktu tidak boleh kosong',
            'areas_of_expertise.required' => 'Bidang Keahlian tidak boleh kosong',
            'address.required'            => 'Alamat Kantor/Faks/Telepon tidak boleh kosong',
            'bank_account_name.required'  => 'Nama Pemilik Bank tidak boleh kosong',
            'bank_account_no.required'    => 'Nomor Rekening Bank tidak boleh kosong',

            'file_partner_contract.*.required' => 'Surat Kesediaan Kerjasama tidak boleh kosong',
            'file_partner_contract.*.mimes'    => 'Surat Kesediaan Kerjasama harus dalam bentuk PDF',
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

        //Check Own Scheme If Checked
        if ($this->input('is_own') === '1')
        {
            if (
                $this->input('own-years') === "" ||
                $this->input('own-dedication_type') === "" ||
                $this->input('own-scheme') === "" ||
                $this->input('own-sponsor') === "" ||
                $this->input('own-member') === "" ||
                $this->input('own-annotation') === ""
            )
            {
                array_push($ret, 'Data mandiri masih belum lengkap');

                return $ret;
            }

            if (! count($this->input('member_nidn')) == $this->input('own-member'))
            {
                array_push($ret, 'Jumlah anggota tidak sesuai dengan data anggota yang diisi');
            }
        } else //Check Period ID
        {
            if (
            ! Period::where('id', $this->input('period_id'))
                ->where('propose_begda', '<=', Carbon::now()->toDateString())
                ->where('propose_endda', '>=', Carbon::now()->toDateString())->exists()
            )
            {
                array_push($ret, 'Scheme yang dipilih tidak valid / sudah tidak dalam masa pengajuan proposal');
            }
            if ($this->input('bank_account_name') === null ||
                $this->input('bank_account_no') === null
            )
            {
                array_push($ret, 'Informasi rekening bank harus diisi');
            }
        }

        //Check file partner contract
        foreach ($this->input('partner_name') as $key => $item)
        {
            if ($this->file('file_partner_contract.' . $key) === null)
            {
                array_push($ret, 'Surat Kesediaan Kerjasama harus diunggah');
                break 1;
            }
        }

        //Check output type
        $valid_output = false;
        foreach ($this->input('output_type') as $key => $item)
        {
            if ($item !== '')
            {
                $valid_output = true;
                if (! Output_type::where('id', $item)->exists())
                {
                    array_push($ret, 'Luaran yang dipilih tidak valid');
                }
            }
        }
        if (! $valid_output)
        {
            array_push($ret, 'Minimal 1 luaran yang dihasilkan harus diisi');
        }
        $output_type_unique = $this->input('output_type');
        $output_type_unique = array_unique($output_type_unique);
        if (count($output_type_unique) !== (count($this->input('output_type'))))
        {
            array_push($ret, 'Luaran yang dipilih tidak boleh duplikasi');
        }

        //Check Member NIDN with SIMSDM Lecturer Table
        foreach ($this->input('member_nidn') as $key => $member_nidn)
        {
            if (! Lecturer::where('employee_card_serial_number', $member_nidn)->exists())
            {
                array_push($ret, 'Anggota yang dipilih tidak valid : ' . $this->input('member_display.' . $key));
            }
        }

        //Check Faculty with SIMSDM Faculty Table
        if (! Faculty::where('faculty_code', $this->input('faculty_code'))->where('is_faculty', 1)->exists())
        {
            array_push($ret, 'Fakultas yang dipilih tidak valid');
        }

        //Check Member Duplicate
        $member_collection = $this->input('member_nidn');
        array_push($member_collection, Auth::user()->nidn);
        $member_collection = array_unique($member_collection);
        if (count($member_collection) !== (count($this->input('member_nidn')) + 1))
        {
            array_push($ret, 'Anggota yang dipilih tidak boleh duplikasi');
        }

        //Check Head Dedication Creation times
        if ($this->input('is_own') !== '1')
        {
            $i_as_member = 0;
            $i_as_head = 0;
            $year = date('Y', strtotime(Carbon::now()->toDateString()));
            $periods = Period::where('years', $year)->get();
            foreach ($periods as $period)
            {
                $propose = $period->propose()->where('created_by', Auth::user()->nidn)->where('is_own', null)->get();
                foreach ($propose as $item)
                {
                    $flow_status = $item->flowStatus()->where('status_code', '<>', 'UT')->first();
                    if ($flow_status !== null)
                    {
                        array_push($ret, '1 Dosen hanya bisa menjadi ( ketua penlitian sebanyak 1 kali dan menjadi anggota sebanyak 2 kali ) atau ( anggota sebanyak 3 kali ) dalam 1 tahun');
                        $i_as_head = 1;
                        break 2;
                    }
                }

                $i_as_member += $i_as_head;
                $proposes = $period->propose()->where('created_by', '<>', Auth::user()->nidn)->where('is_own', null)->get();
                foreach ($proposes as $propose)
                {
                    $member = $item->member()->where('nidn', Auth::user()->nidn)->where('status', 'accepted')->first();
                    if ($member !== null)
                    {
                        $i_as_member++;
                        if ($i_as_member >= 3)
                        {
                            array_push($ret, '1 Dosen hanya bisa menjadi ( ketua penlitian sebanyak 1 kali dan menjadi anggota sebanyak 2 kali ) atau ( anggota sebanyak 3 kali ) dalam 1 tahun');
                            break 2;
                        }
                    }
                }
            }
        }

        return $ret;
    }

}
