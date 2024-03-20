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
use App\Models\Recruit;
use Carbon\Carbon;
use App\Traits\CommonTrait;

class RecruitController extends Controller
{
    private $arrPref = AddressConst::PREFECTURE_BY_AREA;
    private $dir = 'public';

    public function index(Request $request)
    {
        $objData = $this->getList($request);
        $objData = $this->formatData($objData);

        $objData->appends($request->query());

        $arrRecruit = $this->getRecruitByPref();

        return view("$this->dir.recruit", [
            'objData' => $objData,
            'keyword' => $request->keyword,
            'arrPref' => $this->arrPref,
            'arrRecruit' => $arrRecruit,
        ]);
    }

    /**
     * モデル取得
     * @param obj $request
     */
    private function getList($request): object|null
    {
        $objData = null;
        $keyword = $request->keyword;
        $query = Recruit::query();

        $query->select(
            'recruits.id',
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
            ->where('recruits.status', 'public')
            ->where('recruits.end_date', '>=', Carbon::now());

        //ログイン時はstatusがmemberのレコードも表示
        $user = Auth::user();

        if ($user) $query->orWhere('recruits.status', 'member');

        if ($request->has('pref')) $query->where('pref', $request->pref);

        if ($request->has('keyword')) $query = $this->search($keyword, $query);

        $objData = $query
            ->orderBy('recruits.end_date', 'asc')
            ->paginate(10);

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
     * 都道府県ごとの応募数取得
     */

    private function getRecruitByPref(): array
    {
        $arrRecruit = array();

        foreach ($this->arrPref as $areaKey => $areaValue) {
            foreach ($areaValue['pref'] as $key => $value) {
                $amount = Recruit::select('schools.pref')
                    ->join('schools', 'schools.id', '=', 'recruits.school_id')
                    ->where('recruits.status', 'public')
                    ->where('pref', $key)
                    ->where('end_date', '>=', Carbon::now())
                    ->count();
                $arrRecruit[$areaKey][$key] = $amount;
            }
        }

        return $arrRecruit;
    }
}
