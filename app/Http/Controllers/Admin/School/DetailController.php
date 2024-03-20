<?php

namespace App\Http\Controllers\Admin\School;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Consts\AddressConst;
use App\Traits\CommonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DetailController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index(Request $request)
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        return view("admin.school.detail", [
            'objData' => $objData,
        ]);
    }

    public function delete(Request $request)
    {
        $objData = $this->model->find($request->id);

        if ($objData) $result = $objData->delete();

        return redirect("admin/school/index")
            ->with('flash', $result ? '削除しました' : '削除に失敗しました');
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


    private function formatData($objData): object
    {
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;

        $prefKey = $objData->pref;
        $cityKey = $objData->city;

        $objData->pref = $arrPref[$prefKey] ?? null;
        $objData->city = $arrCity[$prefKey][$cityKey] ?? null;
        
        $objData = $this->fillStr($objData, '未入力');

        return $objData;
    }
}
