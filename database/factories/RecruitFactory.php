<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Consts\RecruitConst;

class RecruitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $recruit_type = RecruitConst::RECRUIT_TYPE;
        $activities = RecruitConst::ACTIVITY;
        $payment_types=RecruitConst::PAYMENT_TYPE;
        $commutation_types=RecruitConst::PAYMENT_TYPE;
        $statuses=RecruitConst::STATUS;

        return [
            'header' => 'サンプル件名' . fake()->realText(70),
            'pr' => mt_rand(0, 4) ? 'サンプル紹介文' . fake()->realText(50) : null,
            'recruit_type' => fake()->randomKey($recruit_type),
            'activities' => json_encode(fake()->randomElements(array_keys($activities), mt_rand(0, 5))),
            'other_activities' => mt_rand(0, 4) ? '募集する活動その他' . fake()->realText(100) : null,
            'ontime' => '募集する日時' . fake()->realText(100),
            'payment_type' => fake()->randomKey($payment_types),
            'payment' => mt_rand(0, 4) ? mt_rand(1000, 10000) : null,
            'commutation_type' => fake()->randomKey($commutation_types),
            'commutation' => mt_rand(0, 4) ? mt_rand(1000, 10000) : null,
            'number' => mt_rand(1, 20),
            'status' => fake()->randomKey($statuses),
            'end_date' => fake()->dateTimeBetween('-3 months', '+3 month'),
            'keep' => 0,
            'del_flg' => mt_rand(0, 2) ? 0 : 1,

        ];
    }
}
