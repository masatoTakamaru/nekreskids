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
    
    public function softDeleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => now(), // deleted_at カラムを設定する
            ];
        });
    }
}
