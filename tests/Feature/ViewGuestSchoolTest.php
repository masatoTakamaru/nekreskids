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
}
