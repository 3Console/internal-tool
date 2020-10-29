<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'word' => 'required|max:30',
            'hint' => 'max:300',
            'meaning' => 'required|max: 300',
        ];
    }

    public function messages()
    {
        return [
            'word.required' => "Bạn cần điền từ",
            'meaning.required' => "Bạn cần điền nghĩa"
        ];
    }
}
