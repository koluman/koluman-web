<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class InsuranceAddWebRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => 0,
            'message' => $validator->errors(),
        ], 422));
    }
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'insurance_type' => 'required',
            'insurance_state' => 'required',
            'user_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'insurance_type.required' => 'Sigorta türü alanı zorunludur.',
            'insurance_state.required' => 'Sigorta durumu alanı zorunludur.',
            'user_id.required' => 'Kullnıcı seçimi  zorunlu alandır.',

        ];
    }
}
