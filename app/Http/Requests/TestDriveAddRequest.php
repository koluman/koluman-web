<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestDriveAddRequest extends FormRequest
{
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
