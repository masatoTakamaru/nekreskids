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
use App\Models\Instructor;
use Carbon\Carbon;

class InstructorController extends Controller
{
    private $objEmpty = null;
    private $arrFillable = [];

    public function __construct()
    {
        $model = new Instructor();

        $this->arrFillable = array_merge($model->getFillable(), [
            'email',
            'password',
            'avatar',
            'actPref',
        ]);
        $model->setProps(array_fill_keys($this->arrFillable, null));
        $model->birth = new Carbon();
        $model->gender = 'male';
        $model->activities = [];

        $this->objEmpty = $model;
    }

    public function step1(Request $request)
    {
        //初期化
        $objData = $this->objEmpty;
        $jsonData = json_encode($objData);
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setProps(json_decode($jsonData, true));
        }

        return view('Instructor.step1', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDERS,
        ]);
    }

    public function step1Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $jsonData = json_encode(array_merge($arrData, $request->only($this->arrFillable)));

        //アバター画像をstorageに保存
        if ($request->has('avatar')) {
            $data = base64_decode(str_replace('data:image/png;base64,', '', $request->avatar));
            Storage::put('avatars/01.png', $data);
            //$instructor['avatar_url'] = $path;
        }

        if ($request->transition === 'next') {
            return redirect('/instructor/step2')->with('jsonData', $jsonData);
        }

        return;
    }

    public function step2(Request $request)
    {
        //初期化
        $objData = $this->objEmpty;
        $jsonData = json_encode($objData);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setProps(json_decode($jsonData, true));
        }

        return view('Instructor.step2', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function step2Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $jsonData = json_encode(array_merge($arrData, $request->only($this->arrFillable)));

        if ($request->transition === 'prev') {
            return redirect('/instructor/step1')->with('jsonData', $jsonData);
        }
        if ($request->transition === 'next') {
            return redirect('/instructor/step3')->with('jsonData', $jsonData);
        }

        return;
    }

    public function step3(Request $request)
    {
        //初期化
        $objData = $this->objEmpty;
        $jsonData = json_encode($objData);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setProps(json_decode($jsonData, true));
        }

        return view('Instructor.step3', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'arrActivities' => RecruitConst::ACTIVITIES,
            'arrPrefs' => ['' => '選択して下さい'] + AddressConst::PREFECTURES,
            'arrCities' => json_encode(AddressConst::CITIES),
        ]);
    }

    public function step3Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $jsonData = json_encode(array_merge($arrData, $request->only($this->arrFillable)));
        if ($request->transition === 'prev') {
            return redirect('/instructor/step2')->with('jsonData', $jsonData);
        }
        if ($request->transition === 'confirm') {
            return redirect('/instructor/confirm')->with('jsonData', $jsonData);
        }
    }

    public function confirm(Request $request)
    {
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = new Instructor;
            $objData->setProps(json_decode($jsonData, true));

            return view('Instructor.confirm', [
                'objData' => $objData,
                'jsonData' => $jsonData,
            ]);
        }

        abort(404);
    }
}
