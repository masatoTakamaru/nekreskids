<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'nullable|integer',
            'name' => 'nullable|string|max:128',
            'zip' => 'nullable|integer',
            'pref' => 'nullable|string|max:128',
            'city' => 'nullable|string|max:128',
            'address' => 'nullable|string|max:128',
            'tel1' => 'nullable|string|max:20',
            'tel2' => 'nullable|string|max:20',
            'charge' => 'nullable|string|max:128',
            'score' => 'nullable|        ];
    }

    public function attributes()
    {
        return [
            'user_id' => '',
            'name' => '学校名',
            'zip' => '郵便番号',
            'pref' => '都道府県',
            'city' => '市区町村',
            'address' => '町域・番地・建物名など',
            'tel1' => '電話番号１',
            'tel2' => '電話番号２',
            'charge' => '担当者名',
            'score' => '評価点',
        ];
    }

    public function messages()
    {
        return [
            'user_id.integer' => ':attributeは整数を入力してください。',
            'name.max' => ':attributeは128文字以下で入力してください。',
            'zip.integer' => ':attributeは整数を入力してください。',
            'pref.max' => ':attributeは128文字以下で入力してください。',
            'city.max' => ':attributeは128文字以下で入力してください。',
            'address.max' => ':attributeは128文字以下で入力してください。',
            'tel1.max' => ':attributeは20文字以下で入力してください。',
            'tel2.max' => ':attributeは20文字以下で入力してください。',
            'charge.max' => ':attributeは128文字以下で入力してください。',
        ];
    }
};