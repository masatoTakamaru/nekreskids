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
        $this->model->setAttrs(array_fill_keys($this->model->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        $this->model->password = null;
        $this->model->name = null;
        $this->model->name_kana = null;
        $this->model->avatar_url = null;
        $this->model->avatar = null;
        $this->model->pr = null;
        $this->model->activities = [];
        $this->model->other_activities = null;
        $this->model->ontime = null;
        $this->model->act_areas = ['1' => ['pref' => '', 'city' => '']];
        $this->model->birth = Carbon::now()->format('Y-m-d');
        $this->model->cert = null;
        $this->model->gender = 'male';
        $this->model->zip = null;
        $this->model->pref = null;
        $this->model->city = null;
        $this->model->address = null;
        $this->model->tel = null;
        $this->model->keep = null;
        /*-------------------- ここまで --------------------*/

        $this->fillableExt = array_keys(collect($this->model)->toArray());
        array_push($this->fillableExt, 'password');
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getInstructorUserList($request->keyword);

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
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
            'arrActivities' => RecruitConst::ACTIVITY,
            'jsonActAreas' => json_encode($objData->act_areas),
            'jsonPrefs' => json_encode(['' => '選択して下さい'] + AddressConst::PREFECTURE),
            'jsonCities' => json_encode(['' => ['' => '未選択']] + AddressConst::CITIES),
        ]);
    }

    public function detail(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('delete')) abort(404);

        $objData = $this->model->getInstructorUserDetail($request->id);

        if (empty($objData)) abort(404);

        $objData->avatar_url = asset("storage/avatars/$objData->avatar_url");

        /*--------------- deleteの場合 ---------------*/
        if ($request->isMethod('delete')) {
            $objData->deleteInstructorUser($request->id);
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

            return redirect("admin/$this->dir/index");
        }

        /*--------------- getの場合 ---------------*/
        $objData = $this->model->getSchoolUserDetail($request->id);
        if (empty($objData)) abort(404);

        return view("admin.$this->dir.edit", [
            'objData' => $objData,
        ]);
    }
}
