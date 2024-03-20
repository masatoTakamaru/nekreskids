<?php

namespace App\Consts;

class UserConst
{
    const ROLE = [
        '1' => '指導員',
        '2' => '学校担当者',
        '3' => '運営管理者',
    ];

    const GENDER = [
        'male' => '男性',
        'female' => '女性',
        'other' => '選択しない',
    ];

    const STATUS = [
        'draft' => '下書き',
        'public' => '公開',
        'private' => '非公開',
    ];
}
