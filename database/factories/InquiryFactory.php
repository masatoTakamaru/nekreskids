<?php

namespace Database\Factories;

use App\Traits\FactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class InquiryFactory extends Factory
{
    use FactoryTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->safeEmail(),
            'message' => 'サンプル内容' . fake()->realText(mt_rand(10,500)),
        ];
    }
}
