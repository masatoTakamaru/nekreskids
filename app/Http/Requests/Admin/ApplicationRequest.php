<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'recruit_id' => 'nullable|integer',
            'instructor_id' => 'nullable|integer',
            'message' => 'nullable|string|max:512',
        ];
    }

    public function attributes()
    {
        return [
            'recruit_id' => '募集ID',
            'instructor_id' => '指導員ID',
            'message' => 'メッセージ',
        ];
    }

    public function messages()
    {
        return [
            'recruit_id.integer' => ':attributeは整数を入力してください。',
            'instructor_id.integer' => ':attributeは整数を入力してください。',
            'message.max' => ':attributeは512文字以下で入力してください。',
        ];
    }
};