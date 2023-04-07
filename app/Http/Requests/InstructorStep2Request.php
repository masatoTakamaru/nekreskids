<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class InstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'zip' => 'required|integer|size:7',
            'pref' => 'required|string|max:80',
            'city' => 'required|string|max:80',
            'address' => 'required|string|max:80',
            'tel' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'zip'=>'郵便番号',
            'pref'=>'都道府県',
            'city'=>'市区町村',
            'address'=>'町域・番地・建物名など',
            'tel'=>'電話番号',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
};
