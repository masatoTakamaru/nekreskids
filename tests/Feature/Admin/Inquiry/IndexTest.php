<?php

namespace Tests\Feature\Admin\Inquiry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class IndexTest extends TestCase
{
    /************************* 設定項目 *************************/

    // テストする画面のルート相対パス
    private $path = '/admin/inquiry/index';

    // レコード件数をテストするモデルの変数名
    private $objData = 'objData';

    // 検索パラメータのキー名
    private $paramForKeyword = 'keyword';

    // 検索結果に表示されるデータ

    private $arrValid = [
        'name' => '田中',
        'pref' => 'okinawa',
        'city' => 'nahashi',
    ];

    // 検索結果に表示されないデータ

    private $arrInValid = [
        'name' => '佐藤',
        'pref' => 'yamanashi',
        'city' => 'kofushi',
    ];

    // 検索キーワード

    private $keyword = [
        0 => '田中',
        1 => '田中+沖縄',
        2 => '田中+沖縄+那覇市',
    ];

    /********************* 設定項目ここまで *********************/

    private $model = null;

    private $objValid = null;   // 正規データ
    private $objTest = null;    // テストデータ

    use RefreshDatabase;

    /**
     * 事前処理
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->model = new User();

        // 管理者ユーザーでログイン

        $admin = $this->model->factory()->create(['role' => 3]);
        $this->actingAs($admin);
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

    public function レコードが正しく表示される(): void
    {
        $this->model->factory(3)->hasInstructor()->create(['role' => 1]);

        $response = $this->get($this->path);
        $response->assertOK();
        $records = $response->viewData($this->objData);
        $this->assertCount(3, $records);
    }

    /** @test */

    public function 削除されたレコードが表示されない(): void
    {
        $this->model->factory()->hasInstructor()->create(['role' => 1]);
        $this->model->factory()->hasInstructor()->softDeleted()->create(['role' => 1]);
        $response = $this->get($this->path);
        $response->assertOK();
        $records = $response->viewData($this->objData);
        $this->assertCount(1, $records);
    }


    /** @test */
    public function ペジネーションが表示される(): void
    {
        $this->model->factory(15)->hasInstructor()->create(['role' => 1]);
        $response = $this->get($this->path);
        $response->assertSee('次へ');
    }

    /** @test */
    public function 検索テスト(): void
    {
        $records = null;
        $arrTest = array();
        $arrKey = array_keys($this->arrValid);
        $arrValidValue = array_values($this->arrValid);
        $arrInValidValue = array_values($this->arrInValid);

        $arrValidInvalidFlag = [
            [0 => 1],
            [0 => 0],
            [0 => 1, 1 => 1],
            [0 => 1, 1 => 0],
            [0 => 0, 1 => 1],
            [0 => 0, 1 => 0],
            [0 => 1, 1 => 1, 2 => 1],
            [0 => 1, 1 => 1, 2 => 0],
            [0 => 1, 1 => 0, 2 => 1],
            [0 => 1, 1 => 0, 2 => 0],
            [0 => 0, 1 => 1, 2 => 1],
            [0 => 0, 1 => 1, 2 => 0],
            [0 => 0, 1 => 0, 2 => 1],
            [0 => 0, 1 => 0, 2 => 0],
        ];

        foreach ($arrValidInvalidFlag as $case) {
            $arrCase = array();

            foreach ($case as $key => $value) {
                $arrCase[$arrKey[$key]] = $value ? $arrValidValue[$key] : $arrInValidValue[$key];
            }

            $arrTest[] = $arrCase;
        }

        $this->objValid = $this->model->factory()
            ->hasInstructor($this->arrValid)->create(['role' => 1]);
        $this->objTest = $this->model->factory()
            ->hasInstructor()->create(['role' => 1]);

        // 検索1語


        // 1語case正

        $records = $this->getRecord($arrTest[0], $this->keyword[0]);
        $this->assertCount(2, $records);

        // 1語case誤

        $records = $this->getRecord($arrTest[1], $this->keyword[0]);
        $this->assertCount(1, $records);

        // 検索2語

        // 2語case正正

        $records = $this->getRecord($arrTest[2], $this->keyword[1]);
        $this->assertCount(2, $records);

        // 2語case正誤

        $records = $this->getRecord($arrTest[3], $this->keyword[1]);
        $this->assertCount(1, $records);

        // 2語case誤正

        $records = $this->getRecord($arrTest[4], $this->keyword[1]);
        $this->assertCount(1, $records);

        // 2語case誤誤

        $records = $this->getRecord($arrTest[5], $this->keyword[1]);
        $this->assertCount(1, $records);

        // 検索3語

        // 3語case正正正

        $records = $this->getRecord($arrTest[6], $this->keyword[2]);
        $this->assertCount(2, $records);

        // 3語case正正誤

        $records = $this->getRecord($arrTest[7], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case正誤正

        $records = $this->getRecord($arrTest[8], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case正誤誤

        $records = $this->getRecord($arrTest[9], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case誤正正

        $records = $this->getRecord($arrTest[10], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case誤正誤

        $records = $this->getRecord($arrTest[11], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case誤誤正

        $records = $this->getRecord($arrTest[12], $this->keyword[2]);
        $this->assertCount(1, $records);

        // 3語case誤誤誤

        $records = $this->getRecord($arrTest[13], $this->keyword[2]);
        $this->assertCount(1, $records);
    }

    /**
     * 検索テストのレコード取得
     * @param array $arrData
     */
    private function getRecord($arrTest, $keyword): object
    {
        $this->objTest->instructor->fill($arrTest)->save();

        $path = $this->path . '?' . $this->paramForKeyword . '=' . $keyword;

        $response = $this->get($path);
        $records = $response->viewData($this->objData);

        return $records;
    }
}
