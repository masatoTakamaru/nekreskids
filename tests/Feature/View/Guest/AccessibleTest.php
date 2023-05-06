<?php

namespace Tests\Feature\View\Guest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AccessibleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 各ページが表示される(): void
    {
        $this->seed();

        $response = $this->get('/');
        $response->assertOk();

        $response = $this->get('/login');
        $response->assertOk();

        $response = $this->get('/select');
        $response->assertOk();

        $response = $this->get('/instructor/step1');
        $response->assertOk();

        $response = $this->get('/instructor/step2');
        $response->assertOk();

        $response = $this->get('/instructor/step3');
        $response->assertOk();

        $response = $this->get('/school/create');
        $response->assertOk();

        $model = new User;
        $user = $model->where(['role' => 1, 'del_flg' => 0])->first();
        $this->actingAs($user);

        $response = $this->get('/admin/dashboard');
        $response->assertOk();

        $response = $this->get('/admin/instructor/index');
        $response->assertOk();

        $response = $this->get('/admin/instructor/create');
        $response->assertOk();

        $response = $this->get("/admin/instructor/detail?id=$user->id");
        $response->assertOk();

        $response = $this->get("/admin/instructor/edit?id=$user->id");
        $response->assertOk();

        $user = $model->where(['role' => 2, 'del_flg' => 0])->first();
        $this->actingAs($user);

        $response = $this->get('/admin/school/index');
        $response->assertOk();

        $response = $this->get('/admin/school/create');
        $response->assertOk();

        $response = $this->get("/admin/school/detail?id=$user->id");
        $response->assertOk();

        $response = $this->get("/admin/school/edit?id=$user->id");
        $response->assertOk();

        $school = DB::table('schools')
            ->select('schools.id', 'recruits.school_id')
            ->leftJoin('recruits', 'schools.id', '=', 'recruits.school_id')
            ->where(['schools.del_flg' => 0, 'recruits.del_flg' => 0])
            ->first();

        $response = $this->get('/admin/recruit/index');
        $response->assertOk();

        $response = $this->get("/admin/recruit/create?id=$school->id");
        $response->assertOk();

        $response = $this->get("/admin/recruit/detail?id=$school->id");
        $response->assertOk();

        $response = $this->get("/admin/recruit/edit?id=$user->id");
        $response->assertOk();
    }
}
