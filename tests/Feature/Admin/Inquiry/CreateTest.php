<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Inquiry;

class CreateTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/inquiry/create';
    private $redirectPath = '/admin/inquiry/index';

    // レコード件数をテストするモデルの変数名
    private $objData = 'objData';

    // レコードが生成されたことを確認するカラム名
    private $column = 'email';

    /********************* 設定項目ここまで *********************/

    private $model = null;

    use RefreshDatabase;

    /**
     * 事前処理
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->model = new Inquiry();

        // 管理者ユーザーでログイン

        $user = User::factory()->create(['role' => 3]);
        $this->actingAs($user);
    }

    /** @test */
    public function 管理者は表示できる(): void
    {
        $response = $this->get($this->path);
        $response->assertOK();
    }

    /** @test  */
    public function 未ログインユーザーは表示できない(): void
    {
        auth()->logout();
        $response = $this->get($this->path);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function 管理者以外のログインユーザーは表示できない(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        $response = $this->get($this->path);
        $response->assertStatus(403);
    }

    /** @test */
    public function 管理者はデータを登録できる(): void
    {
        // 入力データ生成

        $objData = $this->model->factory()->create();

        // 入力データ整形

        $arrData = $objData->toArray();

        // postしたらリダイレクトされる

        $response = $this->post($this->path, $arrData);
        $response->assertRedirect($this->redirectPath);

        // データベースに登録したレコードが存在する

        $this->assertDatabaseHas('inquiries', [
            $this->column => $arrData[$this->column],
        ]);
    }

    /** @test */
    public function 未ログインユーザーは登録できない(): void
    {
        auth()->logout();

        // 入力データ生成

        $objData = $this->model->factory()->make();

        // 入力データ整形

        $arrData = $objData->toArray();

        $response = $this->post($this->path, $arrData);
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('inquiries', [
            $this->column => $arrData[$this->column],
        ]);
    }

    /** @test */
    public function 管理者以外のログインユーザーは登録できない(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        // 入力データ生成

        $objData = $this->model->factory()->make();

        // 入力データ整形

        $arrData = $objData->toArray();

        $response = $this->post($this->path, $arrData);
        $response->assertStatus(403);

        $this->assertDatabaseMissing('inquiries', [
            $this->column => $arrData[$this->column],
        ]);
    }
}
