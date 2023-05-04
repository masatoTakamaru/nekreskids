<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;
use App\Models\Instructor;
use App\Models\Inquiry;
use App\Models\KeepInstructor;
use App\Models\KeepRecruit;
use App\Models\Message;
use App\Models\Notice;
use App\Models\Recruit;
use App\Models\School;
use App\Models\SchoolScore;
use App\Models\Search;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Application::truncate();
        Instructor::truncate();
        Inquiry::truncate();
        KeepInstructor::truncate();
        KeepRecruit::truncate();
        Message::truncate();
        Notice::truncate();
        Recruit::truncate();
        School::truncate();
        SchoolScore::truncate();
        Search::truncate();
        User::truncate();

        Storage::deleteDirectory('avatars');

        $amount = 100;

        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 3,
        ]);
        
        User::factory($amount)->hasInstructor(1)->create(['role' => 1]);
        
        $school_users = User::factory($amount)->hasSchool(1)->create(['role' => 2]);
        
        foreach($school_users as $school_user) {
            if (mt_rand(0, 3)) {
                Recruit::factory(mt_rand(1, 10))->create(['school_id' => $school_user->school->id]);
            }
        }
        
        Message::factory($amount)->create();
        Application::factory($amount)->create();
        KeepInstructor::factory($amount)->create();
        KeepRecruit::factory($amount)->create();
        Notice::factory($amount)->create();
        Inquiry::factory($amount)->create();
    }
}
