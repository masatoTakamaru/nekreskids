<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    private $dir = 'message';
    private $model = null;
    private $fillableExt = [];

    public function __construct()
    {
        $this->model = new Message;
        $this->model->setAttrs(array_fill_keys($this->model->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        /*-------------------- ここまで --------------------*/

        $this->fillableExt = array_keys(collect($this->model)->toArray());
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = $this->model->getSchoolUserList($request->keyword);

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
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
}
