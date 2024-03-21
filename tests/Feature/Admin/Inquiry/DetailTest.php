<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DetailTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/instructor/detail';
    private $redirectPath = '/admin/instructor/index';

    // レコード件数をテストするモデルの変数名
    private $objData = 'objData';

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
        $user = $this->model->factory()->hasInstructor()->create(['role' => 1]);
        $this->actingAs($user);

        $response = $this->get($this->path . '?id=' . $user->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function IDが存在しない場合404エラーが表示される(): void
    {
        $user = $this->model->factory()->hasInstructor()->create(['role' => 1]);

        $response = $this->get($this->path . '?id=10000');
        $response->assertStatus(404);
    }

    /** @test */
    public function 削除テスト(): void
    {
        $objData = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->delete($path);
        $this->assertSoftDeleted('users', ['id' => $objData->id]);
    }
}
