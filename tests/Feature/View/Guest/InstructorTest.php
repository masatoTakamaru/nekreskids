<?php

namespace Tests\Feature\View\Guest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instructor;

class InstructorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ１入力欄(): void
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
    public function 指導員ユーザー登録ページ１セッションが存在する場合(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $arrUser = $user->toArray();
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $ir->activities = json_decode($ir->activities, true);
        $ir->act_areas = json_decode($ir->act_areas, true);
        $arrIr = $ir->toArray();
        $arrData = array_merge($arrUser, $arrIr);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/step1');
        $response->assertOk()
            ->assertSee($user->email)
            ->assertSee($ir->name)
            ->assertSee($ir->name_kana)
            ->assertSee($ir->birth)
            ->assertSee($ir->gender)
            ->assertSee($ir->avatar_url);
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ２入力欄(): void
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
    public function 指導員ユーザー登録ページ２セッションが存在する場合(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $arrUser = $user->toArray();
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $ir->activities = json_decode($ir->activities, true);
        $ir->act_areas = json_decode($ir->act_areas, true);
        $arrIr = $ir->toArray();
        $arrData = array_merge($arrUser, $arrIr);
        $jsonData = json_encode($arrData);

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
    public function 指導員ユーザー登録ページ３入力欄(): void
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
    public function 指導員ユーザー登録ページ３セッションが存在する場合(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $arrUser = $user->toArray();
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $ir->activities = json_decode($ir->activities, true);
        $ir->act_areas = json_decode($ir->act_areas, true);
        $arrIr = $ir->toArray();
        $arrData = array_merge($arrUser, $arrIr);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/step3');
        $response->assertOk()
            //->assertSee($ir->other_activities)
            ->assertSee($ir->ontime)
            ->assertSee($ir->cert)
            ->assertSee($ir->pr);
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録確認画面(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $arrUser = $user->toArray();
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $ir->activities = json_decode($ir->activities, true);
        $ir->act_areas = json_decode($ir->act_areas, true);
        $arrIr = $ir->toArray();
        $arrData = array_merge($arrUser, $arrIr);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/confirm');
        $response->assertOk()
            ->assertSee($user->email)
            ->assertSee($ir->name)
            ->assertSee($ir->name_kana)
            ->assertSee($ir->birth)
            ->assertSee($ir->gender)
            ->assertSee($ir->avatar_url)
            ->assertSee($ir->zip)
            ->assertSee($ir->pref)
            ->assertSee($ir->city)
            ->assertSee($ir->address)
            ->assertSee($ir->tel)
            ->assertSee($ir->other_activities)
            ->assertSee($ir->ontime)
            ->assertSee($ir->cert)
            ->assertSee($ir->pr);
    }

    /**
     * @test
     */
    public function 指導員ユーザー登録完了画面(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $arrUser = $user->toArray();
        $ir = Instructor::factory()->create(['user_id' => $user->id]);
        $ir->activities = json_decode($ir->activities, true);
        $ir->act_areas = json_decode($ir->act_areas, true);
        $arrIr = $ir->toArray();
        $arrData = array_merge($arrUser, $arrIr);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/instructor/confirm');
        $response->assertOk();
    }
}
