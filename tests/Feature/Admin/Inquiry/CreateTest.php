<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/instructor/create';
    private $redirectPath = '/admin/instructor/index';

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

        $this->model = new User();

        // 管理者ユーザーでログイン

        $user = $this->model->factory()->create(['role' => 3]);
        $this->actingAs($user);
    }

    /** @test */
    public function 表示テスト(): void
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
    public function 管理者ユーザー以外表示できない(): void
    {
        $user = $this->model->factory()->create(['role' => 1]);
        $this->actingAs($user);

        $response = $this->get($this->path);
        $response->assertStatus(403);
    }

    /** @test */
    public function 登録テスト(): void
    {
        // 入力データ生成

        $objData = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

        // 入力データ整形

        $arrUser = $objData->toArray();
        $arrInstructor = $objData->instructor->toArray();
        $arrData = array_merge($arrUser, $arrInstructor);
        $arrData['email'] = 'test@example.net';
        $arrData['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        // postしたらリダイレクトされる

        $response = $this->post($this->path, $arrData);
        $response->assertRedirect($this->redirectPath);

        // データベースに登録したレコードが存在する

        $this->assertDatabaseHas('users', [
            $this->column => $arrData[$this->column],
        ]);

        $this->assertDatabaseHas('instructors', [
            'name' => $arrData['name'],
        ]);
    }
}
