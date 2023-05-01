<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;


class InstructorController extends Controller
{
    private $model = null;
    private $dir = 'instructor';
    private $fillableExt = [];  //メソッド間の受け渡し項目

    public function __construct()
    {
        $this->model = new User;
        $this->fillableExt = array_merge($this->model->getFillable(), [
            /*-- メソッド間の受け渡し項目を追加する場合はここに記入 --*/
            'name',
            'name_kana',
            'avatar_url',
            'pr',
            'activities',
            'other_activities',
            'ontime',
            'act_areas',
            'birth',
            'cert',
            'gender',
            'zip',
            'pref',
            'city',
            'address',
            'tel',
            'keep',
            'avatar',
            /*--------------------- ここまで ---------------------*/
        ]);
        $this->model->setAttrs(array_fill_keys($this->fillableExt, null));

        /*---------- 初期値を与える場合はここに記入 ----------*/
        $this->model->birth = Carbon::now()->format('Y-m-d');
        $this->model->gender = 'male';
        $this->model->activities = [];
        $this->model->act_areas = ['1' => ['pref' => '', 'city' => '']];
        /*-------------------- ここまで --------------------*/
    }

    public function index(Request $request)
    {

        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getInstructorUserList($request->keywords);

        foreach($objData as $item){
            $item->city = "test";
        }

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keywords' => $request->keywords,
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        /*--------------- postの場合 ---------------*/
        $objData = $this->model;

        if ($request->isMethod('post')) {
            $arrData = array_merge($objData->toArray(), $request->input());
            $jsonData = json_encode($arrData);
            $this->model->newEntry($jsonData, 1, 'public');
            return redirect("/admin/$this->dir/index");
        }

        /*--------------- getの場合 ---------------*/
        return view("admin.$this->dir.create", [
            'genders' => UserConst::GENDERS,
            'status' => UserConst::STATUS,
            'arrActivities' => RecruitConst::ACTIVITIES,
            'jsonActAreas' => json_encode($objData->act_areas),
            'jsonPrefs' => json_encode(['' => '選択して下さい'] + AddressConst::PREFECTURES),
            'jsonCities' => json_encode(['' => ['' => '未選択']] + AddressConst::CITIES),
        ]);
    }

    public function detail(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('delete')) abort(404);

        $objData = $this->model->getSchoolUserDetail($request->id);
        if (empty($objData)) abort(404);

        /*--------------- deleteの場合 ---------------*/
        if ($request->isMethod('delete')) {
            $objData->deleteSchoolUser($request->id);
            return redirect("admin/$this->dir/index");
        }

        return view("admin.$this->dir.detail", [
            'objData' => $objData,
        ]);
    }

    public function edit(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('patch')) abort(404);

        /*--------------- patchの場合 ---------------*/
        if ($request->isMethod('patch')) {
            $arrData = $request->input();
            $arrData['id'] = $request->id;
            $objData = $this->model;
            $objData->updateSchoolUser($arrData);
        }

        /*--------------- getの場合 ---------------*/
        $objData = $this->model->getSchoolUserDetail($request->id);
        if (empty($objData)) abort(404);

        return view("admin.$this->dir.edit", [
            'objData' => $objData,
        ]);
    }
}