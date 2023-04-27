<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SchoolScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'score' => mt_rand(0,4)?mt_rand(1,5):null,
            'del_flg' => mt_rand(0, 4) ? 0 : 1,

        ];
    }        
}