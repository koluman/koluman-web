<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class ShowroomAddRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => 2,
            'message' => $validator->errors()->all(), // Tüm hata mesajlarını al
        ]));
    }
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'car_name' => 'required',
            'company_id' => 'required',
            'car_description' => 'required',
            'car_img_url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'car_name.required' => 'Araba ismini lütfen giriniz.',
            'company_id.required' => 'Firma seçimi zorunludur.',
            'car_description.required' => 'Araba açıklamasını lütfen giriniz.',
            'car_img_url.required' => 'Araba resmi seçimi zorunludur.',

        ];
    }
}
