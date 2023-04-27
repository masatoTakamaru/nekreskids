<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Recruit;

class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_model = new User;
        $recruit_model = new Recruit;
        $user = $user_model->where('role', 1)->inRandomOrder()->first();
        $recruit = $recruit_model->inRandomOrder()->first();

        return [
            'instructor_id' => $user->instructor->id,
            'recruit_id' => $recruit->id,
            'message' => mt_rand(0, 4) ? 'サンプルメッセージ' . fake()->realText(490) : null,
            'del_flg' => mt_rand(0, 2) ? 0 : 1,
        ];
    }
}
