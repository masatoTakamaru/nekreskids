<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class EditController extends Controller
{
    public function index(Request $request): View
    {
        if (Gate::denies('isAdmin')) abort(403);

        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        return view("admin.inquiry.edit", [
            'objData' => $objData,
        ]);
    }

    public function patch(Request $request): RedirectResponse
    {
        $this->update($request->id, $request->input());

        return redirect("admin/inquiry/index")
            ->with('flash', '更新しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Inquiry::find($id);

        return $objData;
    }

    private function update($id, $input): void
    {

        $objData = Inquiry::find($id);
        $objData->fill($input)->save();
    }
}
