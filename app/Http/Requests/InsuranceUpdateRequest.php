<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class InsuranceUpdateRequest extends FormRequest
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
            'insurance_description' => 'required',
            'insurance_type' => 'required',
            'insurance_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'insurance_description.required' => 'Sigorta açıklama alanı zorunludur.',
            'insurance_type.required' => 'Sigorta türü alanı zorunludur.',
            'insurance_id.required' => 'Bu alan  zorunlu alandır.',

        ];
    }
}
