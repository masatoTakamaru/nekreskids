<?php

namespace App\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class Step3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'other_activities' => 'string|max:80',
        ];
    }

    public function attributes(): array
    {
        return [
            'other_activities' => 'その他の活動',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
