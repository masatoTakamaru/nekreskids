<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KeepInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'school_id' => 'nullable|integer',
            'instructor_id' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'school_id' => '学校ID',
            'instructor_id' => '指導員ID',
        ];
    }

    public function messages()
    {
        return [
            'school_id.integer' => ':attributeは整数を入力してください。',
            'instructor_id.integer' => ':attributeは整数を入力してください。',
        ];
    }
};