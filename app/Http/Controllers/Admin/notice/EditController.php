<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Consts\NoticeConst;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EditController extends Controller
{
    public function edit(Request $request): View
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        return view("admin.notice.edit", [
            'objData' => $objData,
            'arrStatus' => NoticeConst::STATUS,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $result = $this->updateEntity($request->id, $request->input());

        return redirect("admin/notice/index")
            ->with('flash', $result ? '更新しました' : '更新に失敗しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Notice::find($id);

        return $objData;
    }

    private function updateEntity($id, $input): bool
    {

        $objData = Notice::find($id);

        if (!$objData) return false;

        $result = $objData->fill($input)->save();

        return $result;
    }
}
