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
            'success' => 422,
            'message' => $validator->errors(),
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
            'car_img_url' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'car_id.required' => 'Araba numarası gelmedi.',
            'car_img_url.required' => 'Resim seçmelisiniz.',

        ];
    }
}
