<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Consts\NoticeConst;
use DateTime;

class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses = NoticeConst::RECRUIT_TYPE;

        return [
            'header' => 'サンプル見出し' . fake()->realText(15),
            'content' => 'サンプル本文' . fake()->realText(990),
            'publish_date' => fake()->dateTimeBetween('-3 months', '+1 week'),
            'status' => fake()->randomKey($statuses),
            'del_flg' => mt_rand(0, 2) ? 0 : 1,
        ];
    }
}
