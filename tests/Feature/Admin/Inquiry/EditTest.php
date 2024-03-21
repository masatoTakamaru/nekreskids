<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class EditTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/instructor/edit';
    private $redirectPath = '/admin/instructor/index';

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

        $this->model = new User();

        // 管理者ユーザーでログイン

        $user = $this->model->factory()->create(['role' => 3]);
        $this->actingAs($user);
    }

    /** @test */
    public function 表示テスト(): void
    {
        $objData = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

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
    public function 管理者ユーザー以外表示できない(): void
    {
        $user = $this->model->factory()->create(['role' => 1]);
        $this->actingAs($user);

        $response = $this->get($this->path . '?id=' . $user->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function IDが存在しない場合404エラーが表示される(): void
    {
        $this->model->factory()->hasInstructor()->create(['role' => 1]);

        $response = $this->get($this->path . '?id=10000');
        $response->assertStatus(404);
    }

    /** @test */
    public function 更新テスト(): void
    {
        // 入力データ生成

        $objData = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

        // postしたらリダイレクトされる

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->patch($path, [
            $this->column => $this->data,
            'name' => 'testName'
        ]);
        $response->assertRedirect($this->redirectPath);

        // データベースに登録したレコードが存在する

        $this->assertDatabaseHas('users', [
            $this->column => $this->data,
        ]);

        $this->assertDatabaseHas('instructors', [
            'name' => 'testName',
        ]);
    }
}
