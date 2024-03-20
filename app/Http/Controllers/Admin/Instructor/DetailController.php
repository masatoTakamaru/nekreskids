<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Consts\UserConst;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DetailController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        return view("admin.instructor.detail", [
            'objData' => $objData,
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $objData = User::find($request->id);

        if ($objData) $objData->delete();

        return redirect("admin/instructor/index")
            ->with('flash', '削除しました');
    }

    private function getEntity($id): object|null
    {
        $objData = User::select(
            'users.id',
            'users.email',
            'users.status',
            'instructors.name',
            'instructors.name_kana',
            'instructors.avatar_url',
            'instructors.pr',
            'instructors.activities',
            'instructors.other_activities',
            'instructors.ontime',
            'instructors.act_areas',
            'instructors.birth',
            'instructors.cert',
            'instructors.gender',
            'instructors.zip',
            'instructors.pref',
            'instructors.city',
            'instructors.address',
            'instructors.tel',
            'instructors.keep'
        )
            ->join('instructors', 'users.id', '=', 'instructors.user_id')
            ->where('users.id', $id)
            ->first();

        return $objData;
    }

    private function formatData($objData): object
    {
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;
        $arrGender = UserConst::GENDER;
        $arrStatus = UserConst::STATUS;
        $arrActivity = RecruitConst::ACTIVITY;

        $objData->avatar_url = asset('storage/avatars/' . $objData->avatar_url);
        $objData->gender = $arrGender[$objData->gender];
        $objData->status = $arrStatus[$objData->status];

        //指導できる活動

        $arrActivityKey = json_decode($objData->activities, true);
        $str = '';

        $str = implode(' ', array_map(function ($value) use ($arrActivity) {
            return isset($arrActivity[$value]) ? $arrActivity[$value] : null;
        }, $arrActivityKey));

        $objData->activities = trim($str);

        //住所

        $prefKey = $objData->pref;
        $cityKey = $objData->city;
        $objData->pref = $this->getPref($prefKey);
        $objData->city = $this->getCity($prefKey, $cityKey);

        //指導できる地域

        $arrActArea = json_decode($objData->act_areas, true) ?? [];

        $objData->act_areas = implode(' ', array_map(function ($actArea) use ($arrPref, $arrCity) {
            $prefKey = $actArea['pref'] ?? null;
            $cityKey = $actArea['city'] ?? null;

            return isset($arrPref[$prefKey], $arrCity[$prefKey][$cityKey])
                ? $arrPref[$prefKey] . $arrCity[$prefKey][$cityKey]
                : null;
        }, $arrActArea));

        $objData = $this->fillStr($objData, null);

        return $objData;
    }
}
