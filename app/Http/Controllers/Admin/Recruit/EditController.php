<?php

namespace App\Http\Controllers\Admin\Recruit;

use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Consts\UserConst;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recruit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditController extends Controller
{
    private $model = null;

    public function __construct()
    {
        $this->model = new Recruit();
    }

    public function index(Request $request): View
    {
        $arrCity = AddressConst::CITY;

        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        foreach ($arrCity as $key => $value) {
            $arrCity[$key] = ['' => '未選択'] + $value;
        }

        return view("admin.recruit.edit", [
            'objData' => $objData,
            'arrGender' => UserConst::GENDER,
            'arrPref' => AddressConst::PREFECTURE,
            'arrCity' => $arrCity,
            'arrActivities' => RecruitConst::ACTIVITY,
            'arrStatus' => UserConst::STATUS,
            'jsonPref' => json_encode(AddressConst::PREFECTURE),
            'jsonCity' => json_encode(AddressConst::CITY),
            'arrPaymentType' => RecruitConst::PAYMENT_TYPE,
            'arrRecruitType' => RecruitConst::RECRUIT_TYPE,
            'arrCommutationType' => RecruitConst::COMMUTATION_TYPE,
            'arrStatus' => RecruitConst::STATUS,
        ]);
    }

    public function patch(Request $request): RedirectResponse
    {
        $this->update($request->id, $request);

        return redirect("admin/recruit/index")
            ->with('flash', '更新しました');
    }

    private function getEntity($id): object|null
    {
        $objData = $this->model->select(
            'recruits.id',
            'recruits.school_id',
            'recruits.header',
            'recruits.pr',
            'recruits.recruit_type',
            'recruits.activities',
            'recruits.other_activities',
            'recruits.ontime',
            'recruits.payment_type',
            'recruits.payment',
            'recruits.commutation_type',
            'recruits.commutation',
            'recruits.number',
            'recruits.status',
            'recruits.end_date',
            'recruits.keep',
            'schools.name',
            'schools.pref',
            'schools.city'
        )
            ->join('schools', 'schools.id', '=', 'recruits.school_id')
            ->where('recruits.id', $id)
            ->first();

        return $objData;
    }

    private function formatData($objData): object
    {
        $objData->avatar_url = '/storage/avatars/' . $objData->avatar_url;
        $objData->activities = json_decode($objData->activities, true);
        $objData->act_areas = json_decode($objData->act_areas, true);

        return $objData;
    }

    private function update($id, $request): bool
    {
        //入力データの整形

        $arrData = $request->input();

        if ($request->has('activities')) {
            $arrData['activities'] = json_encode(array_combine(range(1, count($request->activities)), $request->activities));
        }

        //更新処理

        $objData = $this->model->find($id);

        if (!$objData) return false;

        $objData->fill($arrData)->save();

        return true;
    }
}
