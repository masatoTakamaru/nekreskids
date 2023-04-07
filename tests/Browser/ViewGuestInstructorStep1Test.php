<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;

class ViewGuestInstructorStep1Test extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function 指導員ユーザー登録ページ１表示確認(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('ネクレスキッズ');
        });
    }
}
