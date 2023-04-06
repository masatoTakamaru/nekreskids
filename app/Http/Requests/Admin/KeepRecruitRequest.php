<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KeepRecruitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'instructor_id' => 'nullable|integer',
            'recruit_id' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'instructor_id' => '指導員ID',
            'recruit_id' => '募集ID',
        ];
    }

    public function messages()
    {
        return [
            'instructor_id.integer' => ':attributeは整数を入力してください。',
            'recruit_id.integer' => ':attributeは整数を入力してください。',
        ];
    }
};