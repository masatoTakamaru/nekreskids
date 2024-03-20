<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Instructor;
use App\Models\Recruit;

class KeepRecruitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $objInstructor = Instructor::inRandomOrder()->first();
        $objRecruit = Recruit::inRandomOrder()->first();

        return [
            'instructor_id' => $objInstructor->id,
            'recruit_id' => $objRecruit->id,
        ];
    }
}
