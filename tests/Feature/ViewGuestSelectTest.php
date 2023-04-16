<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Notice;

class ViewGuestSelectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ユーザー登録選択ページが表示される(): void
    {
        $response = $this->get('/select');
        $response->assertOk();
    }
}
