<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class CreateRequestTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/instructor/create';

    // レコード件数をテストするモデルの変数名
    private $objData = 'objData';

    /********************* 設定項目ここまで *********************/

    private $model = null;
    private $arrData = array();

    use RefreshDatabase;

    /**
     * 事前処理
     */
    public function setUp(): void
    {
        parent::setUp();

        // 入力データ生成
        $this->model = new User();
        $objData = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

        // 入力データ整形

        $arrUser = $objData->toArray();
        $arrInstructor = $objData->instructor->toArray();
        $this->arrData = array_merge($arrUser, $arrInstructor);
        $this->arrData['email'] = 'test@example.net';
        $this->arrData['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        // 管理者ユーザーでログイン

        $user = $this->model->factory()->create(['role' => 3]);
        $this->actingAs($user);
    }

    /** @test */
    public function 正規データOK(): void
    {
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function email未入力NG(): void
    {
        $this->arrData['email'] = '';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function emailメールアドレス以外NG(): void
    {
        $this->arrData['email'] = 'abc.com';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function email255文字OK(): void
    {
        $this->arrData['email'] = Str::random(255 - 12) . '@example.com';
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function email256文字(): void
    {
        $this->arrData['email'] = Str::random(256 - 12) . '@example.com';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function email重複NG(): void
    {
        $objData = $this->model->factory()
            ->hasInstructor()->create(['email' => $this->arrData['email'], 'role' => 1]);
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function password未入力NG(): void
    {
        $this->arrData['password'] = '';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function password7文字NG(): void
    {
        $this->arrData['password'] = Str::random(7);
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function password8文字OK(): void
    {
        $this->arrData['password'] = Str::random(8);
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function password255文字OK(): void
    {
        $this->arrData['password'] = Str::random(255);
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function password256文字NG(): void
    {
        $this->arrData['password'] = Str::random(256);
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function name未入力NG(): void
    {
        $this->arrData['name'] = '';
        $this->post($this->path, $this->arrData)->assertInValid();
    }


    /** @test */
    public function name255文字OK(): void
    {
        $this->arrData['name'] = Str::random(255);
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function name256文字NG(): void
    {

        $this->arrData['name'] = Str::random(256);
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function name_kana未入力NG(): void
    {
        $this->arrData['name_kana'] = '';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function name_kana1文字OK(): void
    {
        $this->arrData['name_kana'] = 'ア';
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function name_kana255文字OK(): void
    {
        $this->arrData['name_kana'] = str_repeat('ア', 255);
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function name_kana256文字NG(): void
    {
        $this->arrData['name_kana'] = str_repeat('ア', 256);
        $this->post($this->path, $this->arrData)->assertInValid();
    }


    /** @test */
    public function name_kana空白文字OK(): void
    {
        $this->arrData['name_kana'] = 'ア　イ';
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function name_kana半角空白文字OK(): void
    {
        $this->arrData['name_kana'] = 'ア　イ';
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function name_kana全角空白文字のみNG(): void
    {
        $this->arrData['name_kana'] = '　　　';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function name_kana半角カタカナNG(): void
    {
        $this->arrData['name_kana'] = 'ｱｲｳ';
        $this->post($this->path, $this->arrData)->assertInValid();
    }

    /** @test */
    public function avatar空白OK(): void
    {
        $this->arrData['avatar'] = '';
        $this->post($this->path, $this->arrData)->assertValid();
    }

    /** @test */
    public function avatar_url空白OK(): void
    {
        $this->arrData['avatar_url'] = '';
        $this->post($this->path, $this->arrData)->assertValid();
    }
}
