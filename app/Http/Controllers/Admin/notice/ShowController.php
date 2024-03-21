<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Consts\NoticeConst;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShowController extends Controller
{
    use CommonTrait;

    public function show(Request $request): View
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        return view("admin.notice.show", [
            'objData' => $objData,
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $objData = Notice::find($request->id);

        if ($objData) $objData->delete();

        return redirect("admin/notice/index")
            ->with('flash', '削除しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Notice::find($id);

        return $objData;
    }

    private function formatData($objData): object
    {
        $status = NoticeConst::STATUS;

        $objData->status = $status[$objData->status];

        $objData = $this->fillStr($objData, '未入力');

        return $objData;
    }
}
