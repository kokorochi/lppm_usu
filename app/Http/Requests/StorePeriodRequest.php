<?php

namespace App\Http\Requests;

use App\Category_type;
use App\Dedication_type;
use App\Appraisal;
use Illuminate\Foundation\Http\FormRequest;



class StorePeriodRequest extends FormRequest
{
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
            'years'             => 'required|date_format:Y',
            'category_type'     => 'required',
            'dedication_type'   => 'required',
            'appraisal_type'    => 'required',
            'scheme'            => 'required|max:255',
            'sponsor'           => 'required|max:255',
            'min_member'        => 'required|numeric',
            'max_member'        => 'required|numeric',
            'propose_begda'     => 'required|date',
            'propose_endda'     => 'required|date',
            'review_begda'      => 'required|date',
            'review_endda'      => 'required|date',
            'first_begda'       => 'required|date',
            'first_endda'       => 'required|date',
            'monev_begda'       => 'required|date',
            'monev_endda'       => 'required|date',
            'last_begda'        => 'required|date',
            'last_endda'        => 'required|date',
            'annotation'        => '',
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function($validator){
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        $check = $this->checkBeforeSave();
        if ($check !== '') {
            $validator->errors()->add('sumErrors', $check);
        }
    }

    public function messages()
    {
        return [
            'aspect.*.required' => 'The aspect description field is required',
            'quality.*.required' => 'The quality field is required',
            'quality.*.integer' => 'The quality must be a number',
        ];
    }

    private function checkBeforeSave()
    {
        if(!$this->checkCategoryType()){
            return 'Pilihan kategori tidak ditemukan';
        }
        if(!$this->checkDedicationType()){
            return 'Pilihan jenis pengabdian tidak ditemukan';
        }
        if(!$this->checkAppraisalType()){
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
