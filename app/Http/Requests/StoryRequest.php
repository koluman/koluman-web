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
    
        // Eğer güncelleme yapıyorsanız ve story_big_image veya story_small_image varsa zorunlu olmasın
        if ($this->isMethod('patch') && ($this->has('story_big_image') || $this->has('story_small_image'))) {
            $rules['story_big_image'] = 'sometimes|nullable';
            $rules['story_small_image'] = 'sometimes|nullable';
        } else {
            // Eğer yeni bir kayıt ekleniyorsa, resimler zorunlu olsun
            $rules['story_big_image'] = 'required|file';
            $rules['story_small_image'] = 'required|file';
        }
    
        return $rules;
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
