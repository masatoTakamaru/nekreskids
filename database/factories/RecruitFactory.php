<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Consts\RecruitConst;
use App\Traits\FactoryTrait;

class RecruitFactory extends Factory
{
    use FactoryTrait;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $recruit_type = RecruitConst::RECRUIT_TYPE;
        $activities = RecruitConst::ACTIVITY;
        $payment_types = RecruitConst::PAYMENT_TYPE;
        $commutation_types = RecruitConst::COMMUTATION_TYPE;
        $statuses = RecruitConst::STATUS;

        return [
            'header' => 'サンプル件名' . fake()->realText(mt_rand(10, 20)),
            'pr' => $this->randomNull('サンプル紹介文' . fake()->realText(mt_rand(10, 50))),
            'recruit_type' => fake()->randomKey($recruit_type),
            'activities' => json_encode(fake()->randomElements(array_keys($activities), mt_rand(0, 2))),
            'other_activities' => $this->randomNull('募集する活動その他' . fake()->realText(mt_rand(10, 100))),
            'ontime' => '募集する日時' . fake()->realText(mt_rand(10, 100)),
            'payment_type' => fake()->randomKey($payment_types),
            'payment' => $this->randomNull(mt_rand(1000, 10000)),
            'commutation_type' => fake()->randomKey($commutation_types),
            'commutation' => $this->randomNull(mt_rand(1000, 10000)),
            'number' => mt_rand(1, 20),
            'status' => fake()->randomKey($statuses),
            'end_date' => fake()->dateTimeBetween('-3 months', '+3 month'),
            'keep' => 0,
        ];
    }
}
