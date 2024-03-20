<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'header' => 'nullable|string|max:128',
            'content' => 'nullable|string|max:10000',
            'publish_date' => 'nullable|date',
            'status' => 'nullable|string|max:16',
        ];
    }

    public function attributes()
    {
        return [
            'header' => 'お知らせ見出し',
            'content' => 'お知らせ本文',
            'publish_date' => '告知日',
            'status' => '公開状況',
        ];
    }

    public function messages()
    {
        return [
            'header.max' => ':attributeは128文字以下で入力してください。',
            'content.max' => ':attributeは10000文字以下で入力してください。',
            'publish_date.date' => '有効な:attributeを入力してください。',
            'status.max' => ':attributeは16文字以下で入力してください。',
        ];
    }
};