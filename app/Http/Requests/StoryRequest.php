<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoryRequest extends FormRequest
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
        'story_title' => 'required',
        'company_id' => 'required',
        'story_big_image' => 'sometimes|required|file', // Eğer giriş yapılırsa zorunlu kıl
        'story_small_image' => 'sometimes|required|file', // Eğer giriş yapılırsa zorunlu kıl
    ];
}


    public function messages()
    {
        return [
            'story_title.required' => 'Hikaye başlığı zorunludur',
            'company_id.required' => 'Firma seçimi zorunludur.',
            'story_small_image.file' => 'Hikaye küçük resmi zorunlu alandır.',
            'story_big_image.file' => 'Hikaye büyük resmi zorunlu alandır.',

        ];
    }
}
