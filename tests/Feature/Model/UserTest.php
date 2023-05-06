<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 有効な指導員ユーザーが5件取得される(): void
    {
        //valid
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()
                ->hasInstructor(['del_flg' => 0])
                ->create(['role' => 1, 'del_flg' => 0]);
        }
        //invalid
        for ($i = 0; $i < 50; $i++) {
            $user = User::factory()
                ->hasInstructor()
                ->create(['role' => 1]);
            if ($user->del_flg === 0 && $user->instructor->del_flg === 0) {
                $user->delete();
            }
        }
        $model = new User;
        $users = $model->getInstructorUserList(null);
        $this->assertCount(5, $users);
    }

    /**
     * @test
     */
    public function 検索でユーザーが5件取得される(): void
    {
        //valid
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()
                ->hasInstructor([
                    'name' => 'tanaka',
                    'pref' => 'okinawa',
                    'city' => 'nahashi',
                    'del_flg' => 0,
                ])
                ->create(['role' => 1, 'del_flg' => 0]);
        }
        //invalid
        for ($i = 0; $i < 50; $i++) {
            $user = User::factory()
                ->hasInstructor()
                ->create(['role' => 1]);
            if ($user->del_flg === 0 && $user->instructor->del_flg === 0) {
                $user->delete();
            }
            if ($user->instructor->pref === 'okinawa') {
                $user->delete();
            }
        }

        $model = new User;

        $users = $model->getInstructorUserList('tanaka');
        $this->assertCount(5, $users);

        $users = $model->getInstructorUserList('tanaka 沖縄 那覇');
        $this->assertCount(5, $users);

        $users = $model->getInstructorUserList('tanaka 那覇');
        $this->assertCount(5, $users);

        $users = $model->getInstructorUserList('tanaka 沖縄 糸満');
        $this->assertCount(0, $users);
    }
}
