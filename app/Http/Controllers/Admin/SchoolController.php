<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    private $dir = 'school';
    private $model = null;
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new School;
        $this->fillableExt = array_merge($this->model->getFillable(), [
            /*----------- 項目を追加する場合はここに記入 -----------*/
            'email',
            'password',
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

        $objData = $this->model->getList($request->keywords);

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keywords' => $request->keywords,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.school.school-create');
    }

    public function detail(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('delete')) abort(404);

        $objData = $this->model->getDetail($request->id);
        if (empty($objData)) abort(404);

        /*--------------- deleteの場合 ---------------*/
        if ($request->isMethod('delete')) {
            $objData->delete();
            return redirect("admin/$this->dir/index");
        }

        return view("admin.$this->dir.detail", [
            'objData' => $objData,
        ]);
    }

    public function edit(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('patch')) abort(404);

        $objData = $this->model->getDetail($request->id);
        if (empty($objData)) abort(404);

        return view("admin.$this->dir.edit", [
            'objData' => $objData,
        ]);
    }
}
