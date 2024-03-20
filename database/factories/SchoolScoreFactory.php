<?php

namespace Database\Factories;

use App\Traits\FactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolScoreFactory extends Factory
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
            'score' => $this->randomNull(mt_rand(1, 5)),
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
