<?php

namespace App\Http\Controllers\Admin\Recruit;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Consts\AddressConst;
use App\Traits\CommonTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SchoolIndexController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index(Request $request): View
    {
        $objData = $this->getList($request->keyword);
        $objData = $this->formatData($objData);
        $objData->appends($request->query());

        return view("admin.recruit.schoolIndex", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = $this->model->query();

        $query->select(
            'users.email',
            'schools.id as school_id',
            'schools.name',
            'schools.pref',
            'schools.city',
        )
            ->join('schools', 'users.id', '=', 'schools.user_id')
            ->where('users.role', 2);

        if ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('email', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%');

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
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;

        foreach ($objData as $item) {
            $prefKey = $item->pref;
            $cityKey = $item->city;

            $item->address = '未入力';

            if (isset($arrPref[$prefKey]) && isset($arrCity[$prefKey][$cityKey])) {
                $item->address = $arrPref[$prefKey] . $arrCity[$prefKey][$cityKey];
            }
        }

        return $objData;
    }
}
