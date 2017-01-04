<?php

namespace App\Http\Requests;

use App\Dedication;
use Illuminate\Foundation\Http\FormRequest;

class StoreOutputGuidebookRequest extends FormRequest {
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
            'title'     => 'required',
            'book_year' => 'required|date_format:Y',
            'publisher' => 'required',
            'isbn'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'          => 'Judul Buku harus diisi',
            'book_year.required'      => 'Tahun Buku harus diisi',
            'book_year.date_format:Y' => 'Tahun Buku harus dalam format tahun',
            'publisher.required'      => 'Penerbit harus diisi',
            'isbn.required'           => 'ISBN harus diisi',
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
        $dedication = Dedication::find($this->id);
        $dedication_output_guidebook = $dedication->dedicationOutputGuidebook()->first();
        if ($dedication_output_guidebook === null)
        {
            if ($this->file('file_cover') === null)
            {
                array_push($ret, 'Sampul Depan harus diunggah');
            }
            if ($this->file('file_back') === null)
            {
                array_push($ret, 'Sampul Belakang harus diunggah');
            }
            if ($this->file('file_table_of_contents') === null)
            {
                array_push($ret, 'Daftar Isi harus diunggah');
            }
        }

        return $ret;
    }
}
