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

class RecruitDetailController extends Controller
{
    use CommonTrait;

    private $dir = 'public';

    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $objData = $this->getObj($request->id);

        if(!$objData) abort(404);

        $objData = $this->formatData($objData);

        return view("$this->dir.recruit-detail", [
            'item' => $objData,
            'keyword' => $keyword,
        ]);
    }

    /**
     * モデル取得
     * @param int $id
     */
    private function getObj($id): object|null
    {
        $objData = null;
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
            ->join('schools', 'schools.id', '=', 'recruits.school_id');

        $objData = $query->find($id);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        $objData->end_date = Carbon::parse($objData->end_date);

        $pref = AddressConst::PREFECTURE[$objData->pref];
        $city = AddressConst::CITY[$objData->pref][$objData->city];
        $objData->address = $pref . $city;
        $objData->pr = $objData->pr ? $objData->pr : '本文なし';


        $objData->payment = $objData->payment ? $objData->payment . '円' : 'なし';
        $objData->commutation = $objData->commutation ? $objData->commutation . '円' : 'なし';
        $objData->number = $objData->number ? $objData->number . '人' : 'なし';
        $objData->keep = $objData->keep ? $objData->number . '人' : '登録なし';

        $arrRecruitType = RecruitConst::RECRUIT_TYPE;
        $objData->recruit_type = $arrRecruitType[$objData->recruit_type];

        $arrPaymentType = RecruitConst::PAYMENT_TYPE;
        $objData->payment_type = $arrPaymentType[$objData->payment_type];

        $arrCmtType = RecruitConst::COMMUTATION_TYPE;
        $objData->commutation_type = $arrCmtType[$objData->commutation_type];

        $constActivity = RecruitConst::ACTIVITY;
        $arrActivity = array();

        if ($objData->activities) {
            foreach (json_decode($objData->activities, true) as $value) {
                $arrActivity[] = $constActivity[$value];
            }

            $objData->activities = implode(' ', $arrActivity);
        } else {
            $objData->activities = '登録なし';
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
}
