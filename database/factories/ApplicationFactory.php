<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Instructor;
use App\Models\Recruit;
use App\Traits\FactoryTrait;

class ApplicationFactory extends Factory
{
    use FactoryTrait;

    protected $count = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $objInstructor = Instructor::inRandomOrder()->first();
        $objRecruit = Recruit::inRandomOrder()->first();
        $this->count++;

        return [
            'instructor_id' => $objInstructor->id,
            'recruit_id' => $objRecruit->id,
            'message' => $this->randomNull('サンプル' . $this->count . fake()->realText(mt_rand(10,500))),
        ];
    }
}
