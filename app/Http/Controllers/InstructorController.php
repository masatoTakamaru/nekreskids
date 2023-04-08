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
    private $arrItems = [];

    public function __construct()
    {
        $model = new Instructor();
        $this->objEmpty = $model;
        $this->arrItems = $model->arrItems;
        $this->arrItems += [
            'email',
            'password',
            'avatar',
            'actPref',
        ];
        foreach($model->arrItems as $value) {
            $this->objEmpty[$value] = null;
        }
        $this->objEmpty['birth'] = new Carbon();
        $this->objEmpty['gender'] = 'male';
        $this->objEmpty['activities'] = [];
    }

    public function step1(Request $request)
    {
        //初期化
        $objData = $this->objEmpty;
        $jsonData = json_encode($objData);
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $objData = json_decode($jsonData, true);
        }

        return view('Instructor.step1', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDERS,
        ]);
    }

    public function step1Send(Request $request)
    {
        $objData = json_decode($request->jsonData, true);
        $objData = array_merge($objData, $request->only($this->arrModelItems));
        $jsonData = json_encode($objData);

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
            $objData = json_decode($jsonData, true);
        }

        return view('Instructor.step2', [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function step2Send(Request $request)
    {
        $objData = json_decode($request->jsonData, true);
        $objData = array_merge($objData, $request->only($this->arrModelItems));
        $jsonData = json_encode($objData);

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
            $objData = json_decode($jsonData, true);
        }

        return view('Instructor.step3', [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'arrActivities' => RecruitConst::ACTIVITIES,
            'arrAreas' => AddressConst::AREAS,
            'arrPrefs' => AddressConst::PREFECTURES,
            'arrCities' => AddressConst::CITIES,
        ]);
    }

    public function step3Send(Request $request)
    {
        $objData = json_decode($request->jsonData, true);
        $objData = array_merge($objData, $request->only($this->arrModelItems));
        $jsonData = json_encode($objData);

        if ($request->transition === 'prev') {
            return redirect('/instructor/step2')->with('jsonData', $jsonData);
        }
        if ($request->transition === 'confirm') {
            return redirect('/instructor/confirm')->with($jsonData);
        }

        return;
    }

    public function confirm(Request $request)
    {
        $objData = $this->arrEmpty;
        if (!empty($request->old())) {
            $instructor = array_merge($instructor, $request->old());

            return view('Instructor.confirm', [
                'instructor' => $instructor,
                'data' => json_encode($instructor),
            ]);
        }

        return;
    }
}
