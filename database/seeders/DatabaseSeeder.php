<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Recruit;
use App\Models\Message;
use App\Models\Application;
use App\Models\KeepInstructor;
use App\Models\KeepRecruit;
use App\Models\Notice;
use App\Models\Inquiry;
use App\Models\School;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        Storage::deleteDirectory('public/avatars');

        $amount = 3;      //生成するレコードの件数

        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'role' => 3,
        ]);

        $objData = User::factory($amount)->hasInstructor()->create(['role' => 1]);
        $objData = User::factory($amount)->create(['role' => 2]);

        foreach ($objData as $item) {
            $objSchool = School::factory()->create(['user_id' => $item->id]);
            if (mt_rand(0, 3)) {
                Recruit::factory(mt_rand(1, 10))->create(['school_id' => $objSchool->id]);
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
