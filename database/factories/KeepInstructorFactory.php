<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Recruit;

class KeepInstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_model = new User;
        $instructor = $user_model->where('role', 1)->inRandomOrder()->first();
        $school = $user_model->where('role', 2)->inRandomOrder()->first();

        return [
            'instructor_id' => $instructor->instructor->id,
            'school_id' => $school->school->id,
            'del_flg' => mt_rand(0, 4) ? 1 : 0,
        ];
    }        
}