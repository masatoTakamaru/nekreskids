<?php

namespace Database\Factories;

use App\Consts\NoticeConst;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = NoticeConst::STATUS;

        return [
            'header' => 'サンプル見出し' . fake()->realText(mt_rand(10,15)),
            'content' => 'サンプル本文' . fake()->realText(mt_rand(10,900)),
            'publish_date' => fake()->dateTimeBetween('-3 months', '+1 week'),
            'status' => fake()->randomKey($status),
        ];
    }
}
