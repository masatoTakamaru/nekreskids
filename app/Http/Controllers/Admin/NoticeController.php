<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    private $dir = 'notice';
    private $model = null;
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new Notice;
        $this->fillableExt = array_merge($this->model->getFillable(), [
            /*----------- 項目を追加する場合はここに記入 -----------*/
            /*--------------------- ここまで ---------------------*/]);
        $this->model->setAttrs(array_fill_keys($this->fillableExt, null));

        /*---------- 初期値を与える場合はここに記入 ----------*/
        /*-------------------- ここまで --------------------*/
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getList($request->keyword);

        foreach ($objData as $item) {
            if (strlen($item->header) > 10) {
                $item->header = mb_substr($item->header, 0, 10) . '…';
            }
            if (strlen($item->content) > 10) {
                $item->content = mb_substr($item->content, 0, 10) . '…';
            }
        }

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);
        if ($request->isMethod('get') && empty(School::find($request->id))) abort(404);

        /*--------------- postの場合 ---------------*/
        if ($request->isMethod('post')) {
            $objData = $this->model;
            $arrData = array_merge($objData->toArray(), $request->input());
            $jsonData = json_encode($arrData);
            $this->model->newEntry($jsonData);
            return redirect("/admin/$this->dir/index");
        }
        /*--------------- getの場合 ---------------*/
        return view("admin.$this->dir.create", [
            'school_id' => $request->id,
            'arrRecruitType' => RecruitConst::RECRUIT_TYPE,
            'arrActivities' => RecruitConst::ACTIVITY,
            'arrPaymentType' => RecruitConst::PAYMENT_TYPE,
            'arrCommutationType' => RecruitConst::COMMUTATION_TYPE,
            'arrStatus' => RecruitConst::STATUS,
        ]);
    }

    public function detail(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('delete')) abort(404);

        $objData = $this->model->getDetail($request->id);
        if (empty($objData)) abort(404);

        /*--------------- deleteの場合 ---------------*/
        if ($request->isMethod('delete')) {
            $objData->deleteData($request->id);
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
