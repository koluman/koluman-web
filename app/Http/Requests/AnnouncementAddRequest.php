<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class AnnouncementAddRequest extends FormRequest
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
            'announcement_title' => 'required',
            'announcement_state' => 'required',
            'ckeditor-classic' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'announcement_title.required' => 'Başlık girişi zorunludur.',
            'announcement_state.required' => 'Tür seçimi zorunludur.',
            'ckeditor-classic.required' => 'Açıklama yazmak zorundasnız.',

        ];
    }
}
