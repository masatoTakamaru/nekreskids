<?php

namespace App\Http\Controllers\Admin\Recruit;

use Illuminate\Http\Request;
use App\Models\Recruit;
use App\Http\Controllers\Controller;
use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Traits\CommonTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
        $this->model = new Recruit();
    }

    public function index(Request $request): View
    {
        $objData = $this->getList($request->keyword);
        $objData = $this->formatData($objData);
        $objData->appends($request->query());

        return view("admin.recruit.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = $this->model->query();

        $query->select(
            'recruits.id',
            'recruits.header',
            'recruits.activities',
            'recruits.end_date',
            'recruits.keep',
            'recruits.status',
            'schools.user_id',
            'schools.name',
            'schools.pref',
            'schools.city'
        )
            ->join('schools', 'schools.id', '=', 'recruits.school_id');

        if ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('header', 'like', '%' . $keyword . '%');

                    $query = $this->wherePrefCity($query, $keyword);
                });
            }
        }

        $objData = $query->paginate(10);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        $arrActivity = RecruitConst::ACTIVITY;
        $arrStatus = RecruitConst::STATUS;
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;

        foreach ($objData as $item) {
            $item->header = $this->abbrStr($item->header, 10);

            //募集活動
            $actKey = json_decode($item->activities, true);
            $item->activities = implode(' ', array_intersect_key($arrActivity, array_flip($actKey)));

            if (!$actKey) $item->activities = '未設定';

            //住所
            $prefKey = $item->pref;
            $cityKey = $item->city;

            $item->address = '未入力';

            if (isset($arrPref[$prefKey]) && isset($arrCity[$prefKey][$cityKey])) {
                $item->address = $arrPref[$prefKey] . $arrCity[$prefKey][$cityKey];
            }

            $item->status = $arrStatus[$item->status];
        }

        return $objData;
    }
}
