<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorStep3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (!$this->isMethod('post')) return [];

        return [
            'other_activities' => 'required|string|max:80',
        ];
    }

    public function attributes(): array
    {
        return [
            'other_activities' => 'その他の活動',
        ];
    }
}
