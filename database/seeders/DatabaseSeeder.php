<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Application::truncate();
        \App\Models\Instructor::truncate();
        \App\Models\Inquiry::truncate();
        \App\Models\KeepInstructor::truncate();
        \App\Models\KeepRecruit::truncate();
        \App\Models\Message::truncate();
        \App\Models\Notice::truncate();
        \App\Models\Recruit::truncate();
        \App\Models\School::truncate();
        \App\Models\SchoolScore::truncate();
        \App\Models\Search::truncate();
        \App\Models\User::truncate();

        $amount = 30;

        \App\Models\User::factory()->create(['email' => 'admin@example.com', 'password' => 'password', 'role' => 3]);
        \App\Models\User::factory($amount)->hasInstructor(1)->create(['role' => 1]);
        $schools = \App\Models\User::factory($amount)->hasSchool(1)->create(['role' => 2]);
        $schools->each(function ($school_user) {
            if (mt_rand(0, 4)) {
                \App\Models\Recruit::factory(mt_rand(1, 10))->create(['school_id' => $school_user->school->id]);
            }
        });
        \App\Models\Message::factory($amount)->create();
        \App\Models\Application::factory($amount)->create();
        \App\Models\KeepInstructor::factory($amount)->create();
        \App\Models\KeepRecruit::factory($amount)->create();
        \App\Models\Notice::factory($amount)->create();
        \App\Models\Inquiry::factory($amount)->create();

    }
}
