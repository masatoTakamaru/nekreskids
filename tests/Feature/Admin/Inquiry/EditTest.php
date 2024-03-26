<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Inquiry;

class EditTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/inquiry/edit';
    private $redirectPath = '/admin/inquiry/index';

    // レコード件数をテストするモデルの変数名
    private $objData = 'objData';

    // レコード更新を確認するカラム名
    private $column = 'email';

    // カラムに入力するデータ
    private $data = 'testData@example.com';

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
        $objData = $this->model->factory()->create();

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->get($path);
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

        $response = $this->get($this->path . '?id=' . $user->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function IDが存在しない場合404エラーが表示される(): void
    {
        $this->model->factory()->create();

        $response = $this->get($this->path . '?id=10000');
        $response->assertStatus(404);
    }

    /** @test */
    public function 管理者は更新できる(): void
    {
        // 入力データ生成

        $objData = $this->model->factory()->create();

        // postしたらリダイレクトされる

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->patch($path, [$this->column => $this->data]);
        $response->assertRedirect($this->redirectPath);

        // データベースに登録したレコードが存在する

        $this->assertDatabaseHas('inquiries', [
            $this->column => $this->data,
        ]);
    }

    /** @test */
    public function 未ログインユーザーは更新できない(): void
    {
        auth()->logout();

        // 入力データ生成

        $objData = $this->model->factory()->create();

        // postしたらリダイレクトされる

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->patch($path, [$this->column => $this->data]);
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('inquiries', [
            $this->column => $this->data,
        ]);
    }

    /** @test */
    public function 管理者以外のログインユーザーは更新できない(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        // 入力データ生成

        $objData = $this->model->factory()->create();

        // 入力データ整形

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->patch($path, [$this->column => $this->data]);
        $response->assertStatus(403);

        $this->assertDatabaseMissing('inquiries', [
            $this->column => $this->data,
        ]);
    }
}
