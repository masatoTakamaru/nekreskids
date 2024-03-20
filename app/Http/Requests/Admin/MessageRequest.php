<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sender' => 'required|integer',
            'recipient' => 'required|integer',
            'message' => 'required|string|max:512',
            'read_flg' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'sender' => '送信ユーザーID',
            'recipient' => '受信ユーザーID',
            'message' => 'メッセージ',
            'read_flg' => '既読フラグ',
        ];
    }

    public function messages()
    {
        return [
            'sender.integer' => ':attributeは整数を入力してください。',
            'recipient.integer' => ':attributeは整数を入力してください。',
            'message.max' => ':attributeは512文字以下で入力してください。',
            'read_flg.integer' => ':attributeは整数を入力してください。',
        ];
    }
};