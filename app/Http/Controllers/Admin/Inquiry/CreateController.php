<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CreateController extends Controller
{
    public function __construct()
    {
        Gate::authorize('isAdmin');   
    }

    public function create(): View
    {
        return view("admin.inquiry.create");
    }

    public function store(Request $request): RedirectResponse
    {
        $this->newEntry($request->input());

        return redirect("/admin/inquiry/index")
            ->with('flash', '新規登録されました');
    }

    /**
     * ユーザー情報を保存する関数
     * @param array $arrData
     */
    public function newEntry($arrData): void
    {
        Inquiry::create($arrData);
    }
}
