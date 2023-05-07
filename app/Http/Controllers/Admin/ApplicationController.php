<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Http\Controllers\Controller;


class ApplicationController extends Controller
{
    private $dir = 'application';
    private $model = null;  
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new Application;
        $this->model->setAttrs(array_fill_keys($this->model->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        /*-------------------- ここまで --------------------*/

        $this->fillableExt = array_keys(collect($this->model)->toArray());
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getList($request->keyword, $request->end_date);

        foreach ($objData as $item) {
            if (strlen($item->message) > 10) {
                $item->message = mb_substr($item->message, 0, 10) . '…';
            }
            if (strlen($item->recruit_header) > 15) {
                $item->recruit_header = mb_substr($item->recruit_header, 0, 15) . '…';
            }
        }

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
            'end_date' => !empty($request->end_date) ? $request->end_date : null,
        ]);
    }
}
