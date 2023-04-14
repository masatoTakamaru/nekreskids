<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Consts\RecruitConst;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorStep1Request;
use App\Http\Requests\InstructorStep2Request;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\School;
use Carbon\Carbon;

class SchoolController extends Controller
{
    private $objInit = null;    //初期化済みオブジェクト
    private $fillableExt = [];     //メソッド間の受け渡し項目

    public function __construct()
    {
        $model = new School();
        /* ↓↓↓ メソッド間の受け渡し項目を追加する場合はここに記入 ↓↓↓ */
        $this->fillableExt = array_merge($model->getFillable(), [
            'email',
            'password',
        ]);
        /* ↑↑↑ ここまで ↑↑↑ */
        //全項目にnullを代入
        $model->setAttrs(array_fill_keys($this->fillableExt, null));
        /* ↓↓↓ プロパティに初期値を与える場合はここに記入 ↓↓↓ */
        /* ↑↑↑ ここまで ↑↑↑ */

        $this->objInit = $model;
    }

    public function create(Request $request)
    {
        //初期化
        $objData = $this->objInit;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new School;
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view('School.edit', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));

        if ($request->url === 'confirm') {
            return redirect('/instructor/confirm')->with('jsonData', $jsonData);
        }
    }

    public function confirm(Request $request)
    {
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new School;
            $objData->setAttrs(json_decode($jsonData, true));

            return view('School.confirm', [
                'objData' => $objData,
                'jsonData' => $jsonData,
            ]);
        }

        abort(404);  //セッションが存在しない場合ページを表示しない
    }

    public function insert(Request $request)
    {

    }
}
