<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Instructor;
use App\Models\School;

class KeepInstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $objInstructor = Instructor::inRandomOrder()->first();
        $objSchool = School::inRandomOrder()->first();

        return [
            'instructor_id' => $objInstructor->id,
            'school_id' => $objSchool->id,
        ];
    }        
}