<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
        $this->model = new User();
    }

    public function edit(Request $request): View
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        return view("admin.school.edit", [
            'objData' => $objData,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $result = $this->updateEntity($request->id, $request->input());

        return redirect("admin/school/index")
            ->with('flash', $result ? '更新しました' : '更新に失敗しました');
    }

    private function getEntity($id): object|null
    {
        $objData = $this->model->select(
            'users.id',
            'users.email',
            'users.status',
            'schools.*',
        )
            ->join('schools', 'users.id', '=', 'schools.user_id')
            ->where('users.id', $id)
            ->first();

        return $objData;
    }

    private function updateEntity($id, $input): bool
    {

        $objData = $this->model->find($id);

        if (!$objData) return false;

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $objData->fill($input);
        $objSchool = School::where('user_id', $objData->id)
            ->first()
            ->fill($input);

        DB::transaction(function () use ($objData, $objSchool) {
            $objData->save();
            $objSchool->save();
        });

        return true;
    }
}
