<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class TestDriveAddRequest extends FormRequest
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
            'car_id' => 'required',
            'drive_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'car_id.required' => 'Araba numarası girişi zorunludur.',
            'drive_time.required' => 'Randevu zamanı girişi zorunludur.',
        ];
    }
}
