<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateController extends Controller
{
    public function index(): View
    {
        return view("admin.inquiry.create");
    }

    public function post(Request $request): RedirectResponse
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
