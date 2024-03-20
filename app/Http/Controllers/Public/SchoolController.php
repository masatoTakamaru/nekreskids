<?php

namespace App\Http\Controllers\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\School;
use Carbon\Carbon;
use App\Traits\CommonTrait;

class SchoolController extends Controller
{
    private $arrPref = AddressConst::PREFECTURE_BY_AREA;
    private $dir = 'public';

    public function index(Request $request)
    {

        $objData = $this->getList($request);
        $objData = $this->formatData($objData);
        $arrSchool = $this->getSchoolByPref();

        $objData->appends($request->query());

        return view("$this->dir.school", [
            'objData' => $objData,
            'keyword' => $request->keyword,
            'arrPref' => $this->arrPref,
            'arrSchool' => $arrSchool,
        ]);
    }

    /**
     * モデル取得
     * @param string $keyword   キーワード
     * @param string $endDate   期限
     */
    private function getList($request): object|null
    {
        $objData = null;
        $query = School::query();

        $query->select(
            'id',
            'name',
            'pref',
            'city'
        );

        if ($request->has('pref')) $query->where('pref', $request->pref);

        if($request->keyword) $query = $this->search($request->keyword, $query);

        $objData = $query->paginate(10);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        $pref = AddressConst::PREFECTURE;
        $city = AddressConst::CITY;

        foreach ($objData as $item) {
            $item->header = $this->abbrStr($item->header, 10) ?? '件名なし';
            $item->end_date = Carbon::parse($item->end_date);
            $item->address = $pref[$item->pref] . $city[$item->pref][$item->city];
        }

        return $objData;
    }

    /**
     * キーワード検索
     * @param string $keyword   キーワード
     * @param obj $query        クエリビルダ    
     */
    private function search($keyword, $query): object
    {
        $keywords = $this->splitKeyword($keyword);

        if (!$keywords) return $query;

        foreach ($keywords as $value) {
            $query->where('header', 'like', '%' . $value . '%')
                ->orWhere('name', 'like', '%' . $value . '%');
        }

        return $query;
    }

    /**
     * 都道府県ごとの学校数取得
     */

    private function getSchoolByPref(): array
    {
        $arrSchool = array();

        foreach ($this->arrPref as $areaKey => $areaValue) {
            foreach ($areaValue['pref'] as $key => $value) {
                $amount = School::select('pref')
                    ->where('pref', $key)
                    ->count();
                $arrSchool[$areaKey][$key] = $amount;
            }
        }

        return $arrSchool;
    }
}
