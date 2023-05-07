<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
        $user = new User;
        if(mt_rand(0, 1)) {
            $sender = $user->where('role', 1)->inRandomOrder()->first();
            $recipient = $user->where('role', 2)->inRandomOrder()->first();    
        } else {
            $sender = $user->where('role', 2)->inRandomOrder()->first();
            $recipient = $user->where('role', 1)->inRandomOrder()->first();    
        }
        
        return [
            'sender' => $sender->id,
            'recipient' => $recipient->id,
            'message' => 'サンプルメッセージ' . fake()->realText(20),
            'read_flg' => 0,
            'del_flg' => mt_rand(0, 2) ? 0 : 1,
        ];
    }
}
