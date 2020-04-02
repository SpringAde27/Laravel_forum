<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
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
            'title' => ['required'],
            'content' => ['required', 'min:3'],
            'tags' => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '제목은 필수 입력 항목입니다.',
            'content.required' => '본문은 필수 입력 항목입니다.',
            'content.min' => '본문 내용은 최소 :min자 이상 필요합니다.'
        ];
    }

    public function attributes()
    {
        return [
            'title' => '제목',
            'content' => '본문',
        ];
    }
}
