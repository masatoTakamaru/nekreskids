<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'message' => '内容',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attributeを入力してください。',
            'email.max' => ':attributeは255文字以下で入力してください。',
            'message.required' => ':attributeを入力してください。',
            'message.max' => ':attributeは10000文字以下で入力してください。',
        ];
    }
};