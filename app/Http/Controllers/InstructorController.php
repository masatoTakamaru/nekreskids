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
    private $arrEmpty = null;
    private $arrModelItems = [];

    public function __construct()
    {
        $arr = new Instructor();
        $this->arrEmpty = $arr->arrEmpty;
        $this->arrEmpty['email'] = null;
        $this->arrEmpty['password'] = null;
        $this->arrEmpty['birth'] = new Carbon();
        $this->arrEmpty['avatar'] = null;   //アバター画像のbase64文字列を格納
        $this->arrEmpty['gender'] = 'male';
        $this->arrEmpty['activities'] = [];
        $this->arrEmpty['actPref'] = null;
        $this->arrModelItems = $arr->arrModelItems;
        $this->arrModelItems += [
            'email',
            'password',
            'avatar',
            'actPref',
        ];
    }

    public function step1(Request $request)
    {
        //初期化
        $arrData = $this->arrEmpty;
        $jsonData = json_encode($arrData);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $arrData = json_decode($jsonData, true);
        }

        return view('Instructor.step1', [
            'arrData' => $arrData,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDERS,
        ]);
    }

    public function step1Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $arrData = array_merge($arrData, $request->only($this->arrModelItems));
        $jsonData = json_encode($arrData);

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
        $arrData = $this->arrEmpty;
        $jsonData = json_encode($arrData);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $arrData = json_decode($jsonData, true);
        }

        return view('Instructor.step2', [
            'arrData' => $arrData,
            'jsonData' => $jsonData,
        ]);
    }

    public function step2Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $arrData = array_merge($arrData, $request->only($this->arrModelItems));
        $jsonData = json_encode($arrData);

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
        $arrData = $this->arrEmpty;
        $jsonData = json_encode($arrData);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $arrData = json_decode($jsonData, true);
        }

        return view('Instructor.step3', [
            'arrData' => $arrData,
            'jsonData' => $jsonData,
            'arrActivities' => RecruitConst::ACTIVITIES,
            'arrAreas' => AddressConst::AREAS,
            'arrPrefs' => AddressConst::PREFECTURES,
            'arrCities' => AddressConst::CITIES,
        ]);
    }

    public function step3Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $arrData = array_merge($arrData, $request->only($this->arrModelItems));
        $jsonData = json_encode($arrData);

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
        $arrData = $this->arrEmpty;
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
