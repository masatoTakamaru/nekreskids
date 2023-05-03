<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instructor;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 有効な指導員ユーザーが10件取得される(): void
    {
        //valid
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create(['role' => 1, 'del_flg' => 0]);
            $ir = Instructor::factory()->create(['user_id' => $user->id, 'del_flg' => 0]);
        }
        //invalid
        for ($i = 0; $i < 50; $i++) {
            $user = User::factory()
                ->has(Instructor::factory())
                ->create(['role' => 1]);
            if ($user->del_flg === 0 && $user->instructor->del_flg === 0) {
                $user->delete();
            }
        }
        $model = new User;
        $users = $model->getInstructorUserList(null);
        $this->assertCount(5, $users);
    }
}
