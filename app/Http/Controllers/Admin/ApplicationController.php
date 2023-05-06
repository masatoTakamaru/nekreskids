<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Http\Controllers\Controller;


class ApplicationController extends Controller
{
    private $dir = 'recruit';
    private $model = null;
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new Application;
        $this->model->setAttrs(array_fill_keys($this->model->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        $this->model->recruit_header = null;
        $this->model->instructor_name = null;
        /*-------------------- ここまで --------------------*/

        $this->fillableExt = array_keys(collect($this->model)->toArray());
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getList($request->keyword);

        foreach ($objData as $item) {
            if (strlen($item->header) > 15) {
                $item->header = mb_substr($item->header, 0, 15) . '…';
            }
            $item->area = $item->school->pref . $item->school->city;
        }

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }
}
