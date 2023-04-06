<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Notice;

class ViewGuestIndexTest extends TestCase
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

        $response = $this->get('/index');

        $response->assertSee($notices[0]->header);
        $response->assertSee($notices[1]->header);
        $response->assertDontSee($notices[2]->header);
    }
}
