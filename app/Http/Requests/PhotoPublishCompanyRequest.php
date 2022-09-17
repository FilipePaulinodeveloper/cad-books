<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoPublishCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [            
           // 'publishing_company_photo' => 'required|image|mimes:jpeg,png,jpg',    
        ];
    }

    public function messages()
    {
        return [
        //     'book_photo.required' => 'A Foto do livro é obrigatoria',           
            'book_photo.image' => 'Insira uma imagem',
            'book_photo.mimes:jpeg,png,jpg' => 'O formato não é valido',
        ];
    }
}
