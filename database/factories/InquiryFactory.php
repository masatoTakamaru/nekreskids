<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->email(),
            'message' => 'サンプル内容' . fake()->realText(990),
            'del_flg' => mt_rand(0, 4) ? 1 : 0,
        ];
    }
}
