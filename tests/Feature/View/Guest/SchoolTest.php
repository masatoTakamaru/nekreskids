<?php

namespace Tests\Feature\View\Guest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\School;

class SchoolTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 学校ユーザー登録ページ入力欄表示(): void
    {
        $data = [
            'email',
            'password',
            'name',
            'zip',
            'pref',
            'city',
            'address',
            'tel1',
            'tel2',
            'charge',
        ];
        $response = $this->get('/school/create');
        $response->assertOk();
        foreach ($data as $value) {
            $response->assertSee("name=\"{$value}\"", $escaped = false);
        }
        $response->assertSee('次に進む');
    }

    /**
     * @test
     */
    public function 学校ユーザー登録確認画面表示(): void
    {
        $user = User::factory()->create(['role' => 2]);
        $arrUser = $user->toArray();
        $school = School::factory()->create(['user_id' => $user->id]);
        $arrSc = $school->toArray();
        $arrData = array_merge($arrUser, $arrSc);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/school/confirm');
        $response->assertOk()
            ->assertSee($user->email)
            ->assertSee($user->name)
            ->assertSee($user->zip)
            ->assertSee($user->pref)
            ->assertSee($user->city)
            ->assertSee($user->address)
            ->assertSee($user->tel1)
            ->assertSee($user->tel2)
            ->assertSee($user->charge);
    }

    /**
     * @test
     */
    public function 学校ユーザー登録完了画面表示(): void
    {
        $user = User::factory()->create(['role' => 2]);
        $arrUser = $user->toArray();
        $school = School::factory()->create(['user_id' => $user->id]);
        $arrSc = $school->toArray();
        $arrData = array_merge($arrUser, $arrSc);
        $jsonData = json_encode($arrData);

        $response = $this->withSession(['jsonData' => $jsonData])
            ->get('/school/confirm');
        $response->assertOk();
    }
}
