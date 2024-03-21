<?php

namespace App\Http\Controllers\Admin\Recruit;

use App\Consts\RecruitConst;
use App\Consts\UserConst;
use App\Http\Controllers\Controller;
use App\Models\Recruit;
use App\Models\School;
use App\Traits\InstructorTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateController extends Controller
{
    private $model = null;

    use InstructorTrait;

    public function create(Request $request): View
    {
        $objData = $this->getEntity($request->school_id);

        return view("admin.recruit.create", [
            'arrStatus' => UserConst::STATUS,
            'arrGender' => UserConst::GENDER,
            'arrActivities' => RecruitConst::ACTIVITY,
            'arrRecruitType' => RecruitConst::RECRUIT_TYPE,
            'arrPaymentType' => RecruitConst::PAYMENT_TYPE,
            'arrCommutationType' => RecruitConst::COMMUTATION_TYPE,
            'arrStatus' => RecruitConst::STATUS,
            'school_id' => $objData->id,
            'school_name' => $objData->name,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->newEntry($request);

        return redirect("/admin/recruit/index")
            ->with('flash', '新規作成されました');
    }

    /**
     * 募集登録
     * 
     * @param object $request
     */
    private function newEntry($request): void
    {
        $arrData = $request->input();
        $arrData['activities'] = json_encode($arrData['activities']);

        $this->model
            ->fill($arrData)
            ->create(['school_id' => $arrData['school_id']]);
    }

    /**
     * 学校情報を取得k
     * @param string $id
     */
    private function getEntity($id): object|null
    {
        $objData = School::find($id);

        if (!$objData) abort(404);

        return $objData;
    }
}
