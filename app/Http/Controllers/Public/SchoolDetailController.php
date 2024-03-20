<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Consts\AddressConst;
use App\Models\School;
use Carbon\Carbon;
use App\Traits\CommonTrait;

class SchoolDetailController extends Controller
{
    use CommonTrait;

    private $dir = 'public';

    public function index(Request $request)
    {

        $objData = $this->getObj($request);

        if (!$objData) abort(404);

        $objData = $this->formatData($objData);
        
        return view("$this->dir.school-detail", [
            'objData' => $objData,
        ]);
    }

    /**
     * モデル取得
     * @param string $keyword   キーワード
     * @param string $endDate   期限
     */
    private function getObj($request): object|null
    {
        $objData = null;
        $objData = School::select(
            'id',
            'name',
            'zip',
            'pref',
            'city',
            'address',
            'tel1',
            'tel2',
            'charge',
            'score',
        )
            ->find($request->id);

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

        $zip = $objData->zip;
        $objData->zip = $zip ? substr($zip, 0, 3) . '-' . substr($zip, 3) : '未入力';
        $objData->full_address = $pref[$objData->pref] . $city[$objData->pref][$objData->city]
            . $objData->address;

        if (!$objData->tel1 && !$objData->tel2) $objData->full_tel = '未入力';
        if ($objData->tel1) $objData->full_tel = $objData->tel1;
        if ($objData->tel2) $objData->full_tel = $objData->full_tel . ' / ' . $objData->tel2;
        if (!$objData->score) $objData->score = '評価がありません';

        foreach($objData->recruits as $item) {
            $item->header = $this->abbrStr($item->header, 30) ?? '件名なし';
            $item->end_date = Carbon::parse($item->end_date)->format('Y-m-d');
        }

        return $objData;
    }
}
