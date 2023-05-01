<?php

namespace Tests\Feature\View\Guest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Notice;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function トップページが表示される(): void
    {
        Notice::factory()->count(10)->create();

        $response = $this->get('/');

        $response->assertOk();
    }

    /**
     * @test
     */
    public function お知らせが日付の新しい順に2件が表示される(): void
    {

        Notice::factory()->count(10)->create();
        $notices = Notice::orderBy('publish_date', 'desc')->get();
        $response = $this->get('/');
        $response->assertOk();

        $response->assertSee($notices[0]->header);
        $response->assertSee($notices[1]->header);
        $response->assertDontSee($notices[2]->header);
    }

}
