<?php

namespace App\Http\Controllers\Admin\Recruit;

use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Models\Recruit;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShowController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
        $this->model = new Recruit();
    }

    public function show(Request $request)
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        return view("admin.recruit.show", [
            'objData' => $objData,
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $objData = $this->model->find($request->id);

        if ($objData) $objData->delete();

        return redirect("admin/recruit/index")
            ->with('flash', '削除しました');
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
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;
        $arrStatus = RecruitConst::STATUS;
        $arrActivity = RecruitConst::ACTIVITY;
        $arrRecruitType = RecruitConst::RECRUIT_TYPE;
        $arrPaymentType = RecruitConst::PAYMENT_TYPE;
        $arrCommutationType = RecruitConst::COMMUTATION_TYPE;
        $arrActAreaTemp = array();

        $objData->recruit_type = $arrRecruitType[$objData->recruit_type];
        $objData->payment_type = $arrPaymentType[$objData->payment_type];
        $objData->payment = $objData->payment . '円';
        $objData->commutation_type = $arrCommutationType[$objData->commutation_type];
        $objData->commutation = $objData->commutation . '円';
        $objData->number = $objData->number . '人';
        $objData->status = $arrStatus[$objData->status];

        //指導できる活動

        $arrActivityTemp = json_decode($objData->activities);

        if (!empty($arrActivityTemp)) {
            foreach ($arrActivityTemp as $item) {
                if (isset($arrActivity[$item])) {
                    $arrActivityProcessed[] = $arrActivity[$item];
                }
            }

            $objData->activities = implode(' ', $arrActivityProcessed);
        }

        //住所

        $prefKey = $objData['pref'];
        $cityKey = $objData['city'];

        if (
            isset($arrPref[$prefKey]) &&
            isset($arrCity[$prefKey][$cityKey])
        ) {
            $objData->pref = $arrPref[$prefKey];
            $objData->city = $arrCity[$prefKey][$cityKey];
        }

        //指導できる地域

        $arrActArea = json_decode($objData->act_areas, true);

        if ($arrActArea) {
            foreach ($arrActArea as $actArea) {
                $prefKey = $actArea['pref'];
                $cityKey = $actArea['city'];

                if (
                    isset($arrPref[$prefKey]) &&
                    isset($arrCity[$prefKey][$cityKey])
                ) {
                    $arrActAreaTemp[] = $arrPref[$prefKey] . $arrCity[$prefKey][$cityKey];
                }
            }
        }

        $objData->act_areas = implode(' ', $arrActAreaTemp);

        $objData = $this->fillStr($objData, '未入力');

        if (empty(json_decode($objData->activities))) $objData->activities = '未入力';

        return $objData;
    }
}
