<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'role' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'role' => 'ユーザー種別',
        ];
    }

    public function messages()
    {
        return [
            'email.max' => ':attributeは255文字以下で入力してください。',
            'password.max' => ':attributeは255文字以下で入力してください。',
            'role.integer' => ':attributeは整数を入力してください。',
        ];
    }
};