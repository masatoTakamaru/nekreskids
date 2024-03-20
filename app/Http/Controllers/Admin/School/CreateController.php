<?php

namespace App\Http\Controllers\Admin\School;

use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\CommonTrait;
use App\Traits\SchoolTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateController extends Controller
{
    use CommonTrait, SchoolTrait;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index(): View
    {
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;

        foreach ($arrCity as $key => $value) {
            $arrCity[$key] = ['' => '未選択'] + $value;
        }

        return view("admin.school.create", [
            'arrPref' => ['' => '選択して下さい'] + $arrPref,
            'arrCity' => json_encode($arrCity),
            'status' => UserConst::STATUS,
        ]);
    }

    public function post(Request $request): RedirectResponse
    {
        $arrData = array_merge($this->model->toArray(), $request->input());
        $jsonData = json_encode($arrData);
        $this->newEntry($jsonData, $arrData->status);

        return redirect("/admin/school/index")
            ->with('flash', '新規作成されました');
    }
}
