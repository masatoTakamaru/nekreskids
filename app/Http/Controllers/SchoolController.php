<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorStep1Request;
use App\Http\Requests\InstructorStep2Request;
use App\Models\User;
use Carbon\Carbon;

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

    public function create(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        /*---------- postの場合 ----------*/
        if ($request->isMethod('post')) {
            $arrTemp = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrTemp, $request->only($this->fillableExt)));

            /*---------- 下書き保存 ----------*/
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("$this->dir/draft-complete")->with('jsonData', $jsonData);
            }

            /*---------- ページ遷移 ----------*/
            if ($request->has('transit')) {
                return redirect("/$this->dir/" . $request->transit)->with('jsonData', $jsonData);
            }
        }

        /*---------- getの場合 ----------*/
        $objData = $this->model;
        $jsonData = json_encode($objData);

        /*---------- セッションが存在する場合セッション値を反映 ----------*/
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view("$this->dir.create", [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function confirm(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        /*---------- postの場合 ----------*/
        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));

            /*---------- 下書き保存 ----------*/
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("$this->dir/draft-complete")->with('jsonData', $jsonData);
            }

            /*---------- ページ遷移 ----------*/
            if ($request->has('transit')) {
                return redirect("/$this->dir/" . $request->transit)->with('jsonData', $jsonData);
            }

            return redirect("/$this->dir/complete")->with('jsonData', $jsonData);
        }

        /*---------- getの場合 ----------*/
        $jsonData = $request->session()->get('jsonData');
        $objData = new School;
        $objData->setAttrs(json_decode($jsonData, true));

        /*---------- データを整形する場合はここに記入 ----------*/
        $objData->address = $objData->pref . $objData->city . $objData->address;
        /*--------------------- ここまで ---------------------*/

        return view("$this->dir.confirm", [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        /*---------- getの場合 ----------*/
        $jsonData = $request->session()->get('jsonData');

        /*---------- データを整形する場合はここに記入 ----------*/
        /*--------------------- ここまで ---------------------*/

        $this->model->newEntry($jsonData, 'public');

        return view("$this->dir.complete");
    }

    public function draft_complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        /*---------- getの場合 ----------*/
        $jsonData = $request->session()->get('jsonData');
        $this->model->newEntry($jsonData, 'draft');

        /*---------- データを整形する場合はここに記入 ----------*/
        /*--------------------- ここまで ---------------------*/

        return view("$this->dir.draft-complete");
    }
}
