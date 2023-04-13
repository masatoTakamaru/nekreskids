<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
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
use App\Models\Instructor;
use Carbon\Carbon;

class InstructorController extends Controller
{
    private $objInit = null;    //初期化済みオブジェクト
    private $fillableExt = [];     //メソッド間の受け渡し項目

    public function __construct()
    {
        $model = new Instructor();
        //メソッド間の受け渡し項目を追加する場合はここに記入
        $this->fillableExt = array_merge($model->getfillable(), [
            'email',
            'password',
            'avatar',
            'actPref',
        ]);
        //全項目にnullを代入
        $model->setAttrs(array_fill_keys($this->fillableExt, null));
        //プロパティに初期値を与える場合はここに記入
        $model->birth = new Carbon();
        $model->gender = 'male';
        $model->activities = [];
        $model->act_areas = ['1' => ['pref' => '', 'city' => '']];

        $this->objInit = $model;
    }

    public function step1(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));

            if ($request->has('transition')) {
                return redirect('/instructor/' . $request->transition)->with('jsonData', $jsonData);
            }
        }

        // getの場合
        $objData = $this->objInit;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view('Instructor.step1', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDERS,
        ]);
    }

    public function step2(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));

            if ($request->has('transition')) {
                return redirect('/instructor/' . $request->transition)->with('jsonData', $jsonData);
            }
        }

        //getの場合
        $objData = $this->objInit;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view('Instructor.step2', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function step3(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));
            if ($request->has('transition')) {
                return redirect('/instructor/' . $request->transition)->with('jsonData', $jsonData);
            }
        }

        //getの場合
        $objData = $this->objInit;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view('Instructor.step3', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'arrActivities' => RecruitConst::ACTIVITIES,
            'arrActAreas' => json_encode($objData->act_areas),
            'arrPrefs' => json_encode(['' => '選択して下さい'] + AddressConst::PREFECTURES),
            'arrCities' => json_encode(['' => ['' => '未選択']] + AddressConst::CITIES),
        ]);
    }

    public function confirm(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);
        if (!$request->session()->has('jsonData')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));
            if ($request->has('transition')) {
                return redirect('/instructor/' . $request->transition)->with('jsonData', $jsonData);
            }

            //アバター画像をstorageに保存
            /*
            if ($request->has('avatar')) {
                $data = base64_decode(str_replace('data:image/png;base64,', '', $request->avatar));
                Storage::put('avatars/01.png', $data);
                //$instructor['avatar_url'] = $path;
            }
            */

            return redirect('/instructor/complete')->with('jsonData', $jsonData);
        }

        //getの場合
        $jsonData = $request->session()->get('jsonData');
        $objData = new Instructor;
        $objData->setAttrs(json_decode($jsonData, true));

        //表示用データを整形
        $objData->address = $objData->pref . $objData->city . $objData->address;
        $objData->activities = implode(' ', $objData->activities);
        $actAreas = [];
        foreach ($objData->act_areas as $actArea) {
            $actAreas[] = $actArea['pref'] . $actArea['city'];
        }
        $objData->act_areas = implode('<br>', $actAreas);

        return view('Instructor.confirm', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function complete(Request $request)
    {
    }
}
