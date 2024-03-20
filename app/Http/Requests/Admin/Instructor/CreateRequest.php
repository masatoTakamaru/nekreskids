<?php

namespace App\Http\Requests\Admin\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'name' => 'required|string|max:255',
            'name_kana' => 'required|string|max:255|regex:/^[ァ-ヶー\p{Zs}]+$/u',
            'avatar_url' => 'nullable|string|max:2048',
            'pr' => 'nullable|string|max:10000',
            'activities' => 'nullable|string|max:10000',
            'other_activities' => 'nullable|string|max:255',
            'ontime' => 'nullable|string|max:128',
            'act_pref1' => 'nullable|string|max:16',
            'act_city1' => 'nullable|string|max:16',
            'act_pref2' => 'nullable|string|max:16',
            'act_city2' => 'nullable|string|max:16',
            'act_pref3' => 'nullable|string|max:16',
            'act_city3' => 'nullable|string|max:16',
            'act_pref4' => 'nullable|string|max:16',
            'act_city4' => 'nullable|string|max:16',
            'act_pref5' => 'nullable|string|max:16',
            'act_city5' => 'nullable|string|max:16',
            'gender' => 'required|string|max:255',
            'zip' => 'required|integer',
            'pref' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tel' => 'nullable|string|max:255',
            'keep' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'name' => '名前',
            'name_kana' => '名前カナ',
            'avatar_url' => 'アバター画像URL',
            'pr' => '自己紹介',
            'activities' => '指導できる活動',
            'other_activities' => '指導できる活動（その他）',
            'ontime' => '指導できる曜日や時間帯',
            'act_pref1' => '指導できる都道府県1',
            'act_city1' => '指導できる市区町村1',
            'act_pref2' => '指導できる都道府県2',
            'act_city2' => '指導できる市区町村2',
            'act_pref3' => '指導できる都道府県3',
            'act_city3' => '指導できる市区町村3',
            'act_pref4' => '指導できる都道府県4',
            'act_city4' => '指導できる市区町村4',
            'act_pref5' => '指導できる都道府県5',
            'act_city5' => '指導できる市区町村5',
            'gender' => '性別',
            'zip' => '郵便番号',
            'pref' => '都道府県',
            'city' => '市区町村',
            'address' => '町域・番地・建物名など',
            'tel' => '電話番号',
            'keep' => '気になるリスト登録数',
        ];
    }

    public function messages()
    {
        return [
            'email.max' => ':attributeは255文字以下で入力してください。',
            'password.max' => ':attributeは255文字以下で入力してください。',
            'name.required' => ':attributeを入力してください。',
            'name.max' => ':attributeは128文字以下で入力してください。',
            'name_kana.required' => ':attributeを入力してください。',
            'name_kana.regex' => ':attributeは全角カタカナで入力してください。',
            'name_kana.max' => ':attributeは128文字以下で入力してください。',
            'pr.max' => ':attributeは10000文字以下で入力してください。',
            'activities.max' => ':attributeは10000文字以下で入力してください。',
            'other_activities.max' => ':attributeは255文字以下で入力してください。',
            'ontime.max' => ':attributeは255文字以下で入力してください。',
            'act_pref1.max' => ':attributeは16文字以下で入力してください。',
            'act_city1.max' => ':attributeは16文字以下で入力してください。',
            'act_pref2.max' => ':attributeは16文字以下で入力してください。',
            'act_city2.max' => ':attributeは16文字以下で入力してください。',
            'act_pref3.max' => ':attributeは16文字以下で入力してください。',
            'act_city3.max' => ':attributeは16文字以下で入力してください。',
            'act_pref4.max' => ':attributeは16文字以下で入力してください。',
            'act_city4.max' => ':attributeは16文字以下で入力してください。',
            'act_pref5.max' => ':attributeは16文字以下で入力してください。',
            'act_city5.max' => ':attributeは16文字以下で入力してください。',
            'gender.required' => ':attributeを入力してください。',
            'gender.max' => ':attributeは128文字以下で入力してください。',
            'zip.required' => ':attributeを入力してください。',
            'zip.integer' => ':attributeは整数を入力してください。',
            'pref.required' => ':attributeを入力してください。',
            'pref.max' => ':attributeは255文字以下で入力してください。',
            'city.required' => ':attributeを入力してください。',
            'city.max' => ':attributeは255文字以下で入力してください。',
            'address.required' => ':attributeを入力してください。',
            'address.max' => ':attributeは255文字以下で入力してください。',
            'tel.max' => ':attributeは20文字以下で入力してください。',
            'keep.integer' => ':attributeは整数を入力してください。',
        ];
    }
};