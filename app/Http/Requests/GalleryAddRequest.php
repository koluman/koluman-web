<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class GalleryAddRequest extends FormRequest
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
            'car_id' => 'required',
            'car_img_url' => 'required|file|mimes:jpeg,jpg,png,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'car_id.required' => 'Araba numarası gerekli.',
            'car_img_url.required' => 'Resim seçmelisiniz.',
            'car_img_url.file' => 'Araba resmi zorunlu alandır.',
            'car_img_url.mimes' => 'Araba resmi dosya türü jpeg, jpg, png, gif, webp olmalıdır.',
        ];
    }

    public function attributes()
    {
        return [
            'car_img_url' => 'Araç Resmi', 
        ];
    }
}
