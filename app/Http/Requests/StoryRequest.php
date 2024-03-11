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
       
        $rules = [
            'story_title' => 'required',
            'company_id' => 'required',
            'story_priority' => 'required',
        ];
    
        if ($this->has('story_id')) {
            $rules['story_big_image'] = 'sometimes|nullable';
            $rules['story_small_image'] = 'sometimes|nullable';
        } else {
            // Eğer yeni bir kayıt ekleniyorsa, resimler zorunlu olsun
            $rules['story_big_image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp';
            $rules['story_small_image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp';
        }
    
        return $rules;
    }


    public function messages()
    {
        return [
            'story_title.required' => 'Hikaye başlığı zorunludur',
            'company_id.required' => 'Firma seçimi zorunludur.',
            'story_small_image.mimes' => 'Hikaye küçük resmi dosya türü jpeg, jpg, png, gif, webp olmalıdır.',
            'story_big_image.mimes' => 'hikaye küçük  resmi dosya türü jpeg, jpg, png, gif, webp olmalıdır.',

        ];
    }
}
