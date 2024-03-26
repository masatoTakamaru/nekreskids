<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Controller;
use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Consts\UserConst;
use App\Http\Requests\Admin\Instructor\CreateRequest;
use App\Traits\InstructorTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CreateController extends Controller
{
    use InstructorTrait;

    public function create(): View
    {
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;

        foreach ($arrCity as &$value) {
            $value = ['' => '選択してください'] + $value;
        }

        return view("admin.instructor.create", [
            'arrPref' => ['' => '選択して下さい'] + $arrPref,
            'jsonPref' => json_encode(['' => '選択して下さい'] + $arrPref),
            'jsonCity' => json_encode($arrCity),
            'arrStatus' => UserConst::STATUS,
            'arrGender' => UserConst::GENDER,
            'arrActivities' => RecruitConst::ACTIVITY,
        ]);
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $jsonData = json_encode($request->input());
        $this->newEntry($jsonData, $request->status);

        return redirect("/admin/instructor/index")
            ->with('flash', '新規作成されました');
    }
}
