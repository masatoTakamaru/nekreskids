<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Consts\UserConst;

class SchoolController extends Controller
{
    private $dir = 'school';
    private $model = null;
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new User;
        $this->fillableExt = array_merge($this->model->getFillable(), [
            /*----------- 項目を追加する場合はここに記入 -----------*/
            'name',
            'zip',
            'pref',
            'city',
            'address',
            'tel1',
            'tel2',
            'charge',
            'score',
            /*--------------------- ここまで ---------------------*/
        ]);
        $this->model->setAttrs(array_fill_keys($this->fillableExt, null));

        /*---------- 初期値を与える場合はここに記入 ----------*/
        $this->model->score = 0;
        /*-------------------- ここまで --------------------*/
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getSchoolUserList($request->keywords);

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keywords' => $request->keywords,
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        /*--------------- postの場合 ---------------*/
        if ($request->isMethod('post')) {
            $objData = $this->model;
            $arrData = array_merge($objData->toArray(), $request->input());
            $jsonData = json_encode($arrData);
            $this->model->newEntry($jsonData, 2, 'public');
            return redirect("/admin/$this->dir/index");
        }

        /*--------------- getの場合 ---------------*/
        return view("admin.$this->dir.create", [
            'status' => UserConst::STATUS,
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
