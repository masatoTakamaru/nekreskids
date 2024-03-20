<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = new User();
        $message = null;

        if (mt_rand(0, 1)) {
            $sender = $user->where('role', 1)->inRandomOrder()->first();
            $recipient = $user->where('role', 2)->inRandomOrder()->first();
            $message = '指導員→学校' . fake()->realText(mt_rand(10, 50));
        } else {
            $sender = $user->where('role', 2)->inRandomOrder()->first();
            $recipient = $user->where('role', 1)->inRandomOrder()->first();
            $message = '学校→指導員' . fake()->realText(mt_rand(10, 50));
        }

        return [
            'sender' => $sender->id,
            'recipient' => $recipient->id,
            'message' => $message,
            'read_flg' => mt_rand(0,1),
        ];
    }
}
