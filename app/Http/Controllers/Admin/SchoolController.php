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
        $objData = $this->model;
        $objData->getList($request->keywords);

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keywords' => $request->keywords,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.school.school-create');
    }

    public function detail(Request $request, $id)
    {
        $school = new School;
        $entity = $school->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.school.school-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit(Request $request, $id)
    {
        $school = new School;
        $entity = $school->getEntity($id);

        return view('admin.school.school-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }
}