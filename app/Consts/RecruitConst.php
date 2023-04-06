<?php

namespace App\Consts;

class RecruitConst
{

    const RECRUIT_TYPES = [
        'single' => '単発',
        'regular' => '継続',
    ];

    const ACTIVITIES = [
        'baseball' => '野球',
        'soccer' => 'サッカー',
        'basketball' => 'バスケットボール',
        'track' => '陸上',
        'kendo' => '剣道',
        'swimming' => '水泳',
        'tennis' => '硬式テニス',
        'tabletennis' => '卓球',
        'brassband' => '吹奏楽',
        'art' => '美術',
        'science' => '科学',
        'tea' => '茶道',
        'caligraphy' => '書道',
        'english' => '英語',
        'domestic' => '家庭科',
        'play' => '演劇',
        'broadcast' => '放送',
        'ja_arch' => '弓道',
        'volleyball' => 'バレーボール',
        'badminton' => 'バドミントン',
        'judo' => '柔道',
        'computer' => 'パソコン',
        'music' => '軽音楽',
        'flower' => '華道',
        'camera' => '写真',
    ];

    const PAYMENT_TYPES = [
        'free' => '無償',
        'hour' => '時給',
        'day' => '日給',
        'month' => '月給',
    ];

    const STATUSES = [
        'public' => '全体に公開',
        'member' => '登録ユーザーのみ公開',
        'draft' => '下書き',
        'expire' => '掲載終了',
    ];

    const COMMUTATION_TYPES = [
        'fixed' => 'あり（一律）',
        'flex' => 'あり（通勤形態・距離に応じる）',
        'none' => 'なし',
    ];
}
