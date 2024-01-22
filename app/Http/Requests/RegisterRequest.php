<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
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
            'user_phone' => 'required',
            'user_identity' => 'required',
            'user_name' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'user_phone.required' => 'Kullanıcı telefon numarası girişi zorunludur.',
            'v.required' => 'Kullanıcı tc numarası girişi zorunludur.',
            'user_name.required' => 'Kullanıcı adsoyad girişi zorunludur.',

        ];
    }
}
