<?php

namespace App\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class Step1Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:80',
            'password' => 'required|string|max:80',
            'name' => 'required|string|max:80',
            'name_kana' => ['required', 'string', 'max:80', 'regex:/^[\sァ-ヴー]+$/u'],
            'avatar' => 'nullable',
            'avatar_url' => 'nullable',
            'gender' => 'required|string|max:128',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'name' => '名前',
            'name_kana' => '名前カナ',
            'avatar' => 'アバター',
            'gender' => '性別',
        ];
    }

    public function messages()
    {
        return [
            'name_kana.regex' => ':attributeは全角カタカナで入力してください。'
        ];
    }
};
