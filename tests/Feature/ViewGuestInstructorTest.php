<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Notice;
use App\Models\User;
use App\Models\Instructor;

class ViewGuestInstructorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ１入力欄表示確認(): void
    {
        $response = $this->get('/instructor/step1');
        $response->assertOk()
            ->assertSee("name=\"email\"", $escaped = false)
            ->assertSee("name=\"password\"", $escaped = false)
            ->assertSee("name=\"name\"", $escaped = false)
            ->assertSee("name=\"name_kana\"", $escaped = false)
            ->assertSee("name=\"birth\"", $escaped = false)
            ->assertSee("name=\"gender\"", $escaped = false)
            ->assertSee("name=\"avatar\"", $escaped = false)
            ->assertSee("次に進む");
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ１セッションが存在する場合の入力確認(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $data = [
            'email' => $ir->user->email,
            'password' => $ir->user->password,
            'name' => $ir->name,
            'name_kana' => $ir->name_kana,
            'birth' => $ir->birth,
            'gender' => $ir->gender,
            'avatar' => null,
            'avatar_url' => $ir->avatar_url,
        ];
        $jsonData = json_encode($data);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/step1');
        $response->assertOk()
            ->assertSee($ir->user->email)
            ->assertSee($ir->user->password)
            ->assertSee($ir->name)
            ->assertSee($ir->name_kana)
            ->assertSee($ir->birth)
            ->assertSee($ir->gender)
            ->assertSee($ir->avatar_url)
            ;
    }
}
