<?php

namespace Tests\Feature\Admin\Inquiry;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ShowTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/inquiry/show';
    private $redirectPath = '/admin/inquiry/index';

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

        $this->model = new Inquiry();

        // 管理者ユーザーでログイン

        $user = User::factory()->create(['role' => 3]);
        $this->actingAs($user);
    }

    /** @test */
    public function 表示テスト(): void
    {
        $objData = $this->model->factory()->create();

        $response = $this->get($this->path . '?id=' . $objData->id);
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
        $user = User::factory()->hasInstructor()->create(['role' => 1]);
        $this->actingAs($user);

        $objData = $this->model->factory()->create();

        $response = $this->get($this->path . '?id=' . $objData->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function IDが存在しない場合404エラーが表示される(): void
    {
        $response = $this->get($this->path . '?id=10000');
        $response->assertStatus(404);
    }

    /** @test */
    public function 管理者はデータを削除できる(): void
    {
        $objData = $this->model->factory()->create();

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->delete($path);
        $this->assertSoftDeleted('inquiries', ['id' => $objData->id]);
    }

    /** @test */
    public function 管理者以外はデータを削除できない(): void
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        $objData = $this->model->factory()->create();

        $path = $this->path . '?id=' . $objData->id;

        $response = $this->delete($path);
        $response->assertStatus(403);
        $this->assertDatabaseHas('inquiries', ['id' => $objData->id]);
    }
}
