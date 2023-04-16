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
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;

class SchoolController extends Controller
{
    private $objInit = null;    //初期化済みオブジェクト
    private $fillableExt = [];  //メソッド間の受け渡し項目

    public function __construct()
    {
        $model = new School();
        $this->fillableExt = array_merge($model->getFillable(), [
            /*  メソッド間の受け渡し項目を追加する場合はここに記入  */
            'email',
            'password',
            /*  ここまで  */]);
        $model->setAttrs(array_fill_keys($this->fillableExt, null));
        /*  初期値を与える場合はここに記入  */
        $model->score = 0;
        /*  ここまで  */

        $this->objInit = $model;
    }

    public function create(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));

            if ($request->has('transit')) {
                return redirect('/school/' . $request->transit)->with('jsonData', $jsonData);
            }
        }
        // getの場合
        $objData = $this->objInit;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new School;
            $objData->setAttrs(json_decode($jsonData, true));
        }
        return view('school.create', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function confirm(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));
            if ($request->has('transit')) {
                return redirect('/school/' . $request->transit)->with('jsonData', $jsonData);
            }

            return redirect('/school/complete')->with('jsonData', $jsonData);
        }

        //getの場合
        $jsonData = $request->session()->get('jsonData');
        $objData = new School;
        $objData->setAttrs(json_decode($jsonData, true));

        /*  表示用データを整形する場合はここ  */
        $objData->address = $objData->pref . $objData->city . $objData->address;
        /*  ここまで  */

        return view('school.confirm', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        //getの場合
        $jsonData = $request->session()->get('jsonData');
        $objData = new School;
        $objData->setAttrs(json_decode($jsonData, true));

        /*  保存データを整形する場合はここ  */
        /*  ここまで  */

        $model = new User;
        $user = $model->create([
            'name' => $objData->name,
            'email' => $objData->email,
            'password' => bcrypt($objData->password),
            'role' => 2,
        ]);

        $arrData = $objData->toArray();
        $user->school()->create($arrData);

        return view('school.complete');
    }
}

