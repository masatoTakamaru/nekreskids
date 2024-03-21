<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Consts\NoticeConst;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateController extends Controller
{
    public function create(): View
    {
        return view("admin.notice.create", [
            'arrStatus' => NoticeConst::STATUS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $objData = $this->newEntry($request->input());

        return redirect("/admin/notice/index")
            ->with('flash', $objData ? '新規登録されました' : '新規登録に失敗しました');
    }

    /**
     * ユーザー情報を保存する関数
     * 
     * @param array $arrData
     */
    public function newEntry($arrData): object
    {
        $objData = Notice::create($arrData);

        return $objData;
    }
}
