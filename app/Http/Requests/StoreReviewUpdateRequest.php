<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\ReviewPropose;

class StoreReviewUpdateRequest extends FormRequest {
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
            'score.*' => 'required|numeric|min:1|max:7',
            'recommended_amount' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'score.*.required' => 'Skor harus diisi',
            'score.*.numeric'  => 'Skor harus angka',
            'score.*.min'      => 'Skor diisi 1-7',
            'score.*.max'      => 'Skor diisi 1-7',
            'recommended_amount.required' => 'Rekomendasi jumlah dana harus diisi',
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
        $review_propose = ReviewPropose::where('propose_id', $this->id)->where('nidn', Auth::user()->nidn)->first();
        if($review_propose !== null)
        {
            array_push($ret, 'Sudah pernah direview sebelumnya, tidak diperkenankan untuk mengubah hasil review sebelumnya');
        }
        return $ret;
    }
}
