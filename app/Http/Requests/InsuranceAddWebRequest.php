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
            'insurance_state' => 'sometimes|required',
            'user_id' => 'sometimes|required',
            'insurance_type' => 'sometimes|required',

        ];
    }

    public function messages()
    {
        return [
            'insurance_state.required' => 'Sigorta durumu seçimi zorunludur.',
            'user_id.required' => 'Kullanıcı alanı seçimi zorunludur.',
            'insurance_type.required' => 'Sigorta türü seçimi zorunludur.',

        ];
    }
}
