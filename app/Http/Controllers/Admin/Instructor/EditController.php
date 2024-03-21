<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Consts\UserConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\InstructorTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class EditController extends Controller
{
    use InstructorTrait;

    public function edit(Request $request): View
    {
        if (Gate::denies('isAdmin')) abort(403);

        $arrCity = AddressConst::CITY;

        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        foreach ($arrCity as $key => $value) {
            $arrCity[$key] = ['' => '未選択'] + $value;
        }

        return view("admin.instructor.edit", [
            'objData' => $objData,
            'arrGender' => UserConst::GENDER,
            'arrPref' => AddressConst::PREFECTURE,
            'arrCity' => $arrCity,
            'arrActivities' => RecruitConst::ACTIVITY,
            'arrStatus' => UserConst::STATUS,
            'jsonPref' => json_encode(['' => '未選択'] + AddressConst::PREFECTURE),
            'jsonCity' => json_encode($arrCity),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->updateEntity($request->id, $request);

        return redirect("admin/instructor/index")
            ->with('flash', '更新しました');
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
        // アバター画像
        $objData->avatar_url = 'avatars/' . $objData->avatar_url;
        $imageData = Storage::disk('public')->get($objData->avatar_url);
        $mimeType = Storage::disk('public')->mimeType($objData->avatar_url);
        $objData->avatar = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        $objData->activities = $objData->activities ? json_decode($objData->activities, true) : [];

        $arrData = json_decode($objData->act_areas, true);

        if (!$arrData) {
            $arrData = [];
            for ($i = 1; $i <= 5; $i++) {
                $arrData[$i] = ['pref' => '', 'city' => ''];
            }
        }

        foreach ($arrData as &$item) {
            $item['pref'] = $item['pref'] ?? '';
            $item['city'] = $item['city'] ?? '';
        }

        $objData->act_areas = $arrData;

        return $objData;
    }

    private function updateEntity($id, $request): void
    {
        //入力データの整形

        $arrData = $request->input();

        if ($request->has('password')) $arrData['password'] = bcrypt($request->password);
        if ($request->has('activities')) {
            $arrData['activities'] = json_encode(array_combine(range(1, count($request->activities)), $request->activities));
        }

        if (!empty($arrData['act_area'])) {
            $arrData['act_areas'] = json_encode($arrData['act_areas']);
        }

        //アバター画像の保存

        if (!empty($arrData['avatar'])) {
            $arrData['avatar_url'] = $this->avatarSave($arrData['avatar']);
        }

        //更新処理

        $objData = User::find($id);

        $objData->fill($arrData);
        $objData->instructor->fill($arrData);

        DB::transaction(function () use ($objData) {
            $objData->save();
            $objData->instructor->save();
        });
    }
}
