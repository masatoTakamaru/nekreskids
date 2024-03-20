<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class DetailController extends Controller
{
    public function index(Request $request): View
    {
        if (Gate::denies('isAdmin')) abort(403);

        $objData = $this->getEntity($request->id);

        return view("admin.inquiry.detail", [
            'objData' => $objData,
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $objData = Inquiry::find($request->id);

        if ($objData) $objData->delete();

        return redirect("admin/inquiry/index")
            ->with('flash', '削除しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Inquiry::find($id);

        if (empty($objData)) abort(404);

        return $objData;
    }
}
