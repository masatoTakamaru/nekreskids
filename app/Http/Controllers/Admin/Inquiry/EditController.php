<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class EditController extends Controller
{
    public function __construct()
    {
        Gate::authorize('isAdmin');   
    }

    public function edit(Request $request): View
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        return view("admin.inquiry.edit", [
            'objData' => $objData,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->updateEntity($request->id, $request->input());

        return redirect("admin/inquiry/index")
            ->with('flash', '更新しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Inquiry::find($id);

        return $objData;
    }

    private function updateEntity($id, $input): void
    {

        $objData = Inquiry::find($id);
        $objData->fill($input)->save();
    }
}
