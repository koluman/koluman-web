<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class FormsAddRequest extends FormRequest
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
            'type' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Form tipi girişi zorunludur.',
            'firstname.required' => 'Ad alanı zorunludur.',
            'lastname.required' => 'Soyad alanı zorunludur.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'email.required' => 'Mail alanı zorunludur.',
            'message.required' => 'Mesaj alanı zorunludur.',

        ];
    }
}
