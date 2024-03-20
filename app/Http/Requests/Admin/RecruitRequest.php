<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RecruitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'school_id' => 'nullable|integer',
            'header' => 'nullable|string|max:128',
            'pr' => 'nullable|string|max:10000',
            'recruit_type' => 'nullable|string|max:16',
            'activities' => 'nullable|string|max:10000',
            'other_activities' => 'nullable|string|max:128',
            'ontime' => 'nullable|string|max:128',
            'payment_type' => 'nullable|string|max:16',
            'payment' => 'nullable|integer',
            'commutation_type' => 'nullable|integer',
            'commutation' => 'nullable|integer',
            'number' => 'nullable|integer',
            'status' => 'nullable|string|max:16',
            'end_date' => 'nullable|date',
            'keep' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'school_id' => '学校ID',
            'header' => '件名',
            'pr' => '紹介文',
            'recruit_type' => '募集種別',
            'activities' => '募集する活動',
            'other_activities' => '募集する活動（その他）',
            'ontime' => '募集する日時',
            'payment_type' => '支払い種別',
            'payment' => '給与額（円）',
            'commutation_type' => '交通費の支給',
            'commutation' => '交通費（円）',
            'number' => '募集人数（人）',
            'status' => '公開状況',
            'end_date' => '募集期限日',
            'keep' => '気になるリスト登録数',
        ];
    }

    public function messages()
    {
        return [
            'school_id.integer' => ':attributeは整数を入力してください。',
            'header.max' => ':attributeは128文字以下で入力してください。',
            'pr.max' => ':attributeは10000文字以下で入力してください。',
            'recruit_type.max' => ':attributeは16文字以下で入力してください。',
            'activities.max' => ':attributeは10000文字以下で入力してください。',
            'other_activities.max' => ':attributeは128文字以下で入力してください。',
            'ontime.max' => ':attributeは128文字以下で入力してください。',
            'payment_type.max' => ':attributeは16文字以下で入力してください。',
            'payment.integer' => ':attributeは整数を入力してください。',
            'commutation_type.integer' => ':attributeは整数を入力してください。',
            'commutation.integer' => ':attributeは整数を入力してください。',
            'number.integer' => ':attributeは整数を入力してください。',
            'status.max' => ':attributeは16文字以下で入力してください。',
            'end_date.date' => '有効な:attributeを入力してください。',
            'keep.integer' => ':attributeは整数を入力してください。',
        ];
    }
};