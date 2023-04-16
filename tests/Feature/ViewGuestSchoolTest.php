<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Notice;
use App\Models\User;
use App\Models\Instructor;

class ViewGuestSchoolTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 学校ユーザー登録ページ１入力欄表示確認(): void
    {
        $data = [
            'email',
            'password',
            'name',
            'name_kana',
            'birth',
            'gender',
            'avatar',
        ];
        $response = $this->get('/instructor/step1');
        $response->assertOk();
        foreach ($data as $value) {
            $response->assertSee("name=\"{$value}\"", $escaped = false);
        }
        $response->assertSee('次に進む');
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
            ->assertSee($ir->avatar_url);
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ２入力欄表示確認(): void
    {
        $data = [
            'zip',
            'pref',
            'city',
            'address',
            'tel',
        ];
        $response = $this->get('/instructor/step2');
        $response->assertOk();
        foreach ($data as $value) {
            $response->assertSee("name=\"{$value}\"", $escaped = false);
        }
        $response->assertSee("前に戻る")
            ->assertSee("次に進む");
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ２セッションが存在する場合の入力確認(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $data = [
            'zip' => $ir->zip,
            'pref' => $ir->pref,
            'city' => $ir->city,
            'address' => $ir->address,
            'tel' => $ir->tel,
        ];
        $jsonData = json_encode($data);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/step2');
        $response->assertOk()
            ->assertSee($ir->zip)
            ->assertSee($ir->pref)
            ->assertSee($ir->city)
            ->assertSee($ir->address)
            ->assertSee($ir->tel);
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ３入力欄表示確認(): void
    {
        $data = [
            'activities[]',
            'other_activities',
            'ontime',
            'cert',
            'pr',
        ];
        $response = $this->get('/instructor/step3');
        $response->assertOk();
        foreach ($data as $value) {
            $response->assertSee("name=\"{$value}\"", $escaped = false);
        }
        $response->assertSee("前に戻る")
            ->assertSee("確認画面へ");
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ３セッションが存在する場合の入力確認(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $data = [
            'activities' => json_decode($ir->activities,true),
            'other_activities' => $ir->other_activities,
            'ontime' => $ir->ontime,
            'act_areas' => json_decode($ir->act_areas, true),
            'cert' => $ir->cert,
            'pr' => $ir->pr,
        ];
        $jsonData = json_encode($data);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/step3');
        $response->assertOk()
            ->assertSee($ir->other_activities)
            ->assertSee($ir->ontime)
            ->assertSee($ir->cert)
            ->assertSee($ir->pr);
    }
}
