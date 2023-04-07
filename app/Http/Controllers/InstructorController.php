<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorStep1Request;
use App\Consts\UserConst;
use App\Models\Instructor;
use Carbon\Carbon;

class InstructorController extends Controller
{
    private $formItems = [
        'email',
        'password',
        'name',
        'name_kana',
        'avatar',
        'avatar_url',
        'pr',
        'activities',
        'other_activities',
        'ontime',
        'act_prefcities',
        'birth',
        'cert',
        'gender',
        'zip',
        'pref',
        'city',
        'address',
        'tel',
        'keep',
    ];

    private $instructorInit = null;

    public function __construct()
    {
        $this->instructorInit = array_fill_keys($this->formItems, null);
        $this->instructorInit['birth'] = new Carbon();
        $this->instructorInit['gender'] = 'male';
    }

    public function step1(Request $request)
    {
        //初期化
        $instructor = $this->instructorInit;
        $jsonData = json_encode($instructor);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $instructor = json_decode($jsonData, true);
        }

        return view('Instructor.step1', [
            'instructor' => $instructor,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDERS,
        ]);
    }

    public function step1Send(InstructorStep1Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $instructor = array_merge($arrData, $request->only($this->formItems));
        $jsonData = json_encode($instructor);

        //アバター画像をstorageに保存
        if ($request->has('avatar')) {
            $data = base64_decode(str_replace('data:image/png;base64,', '', $request->avatar));
            Storage::put('avatars/01.png', $data);
            //$instructor['avatar_url'] = $path;
        }

        if ($request->transition === 'forward') {
            return redirect('/instructor/step2')->with('jsonData', $jsonData);
        }

        return;
    }

    public function step2(Request $request)
    {
        //初期化
        $instructor = $this->instructorInit;
        $jsonData = json_encode($instructor);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $instructor = json_decode($jsonData, true);
        }

        return view('Instructor.step2', [
            'instructor' => $instructor,
            'jsonData' => $jsonData,
        ]);
    }

    public function step2Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $instructor = array_merge($arrData, $request->only($this->formItems));
        $jsonData = json_encode($instructor);

        if ($request->transition === 'back') {
            return redirect('/instructor/step1')->with('jsonData', $jsonData);
        }
        if ($request->transition === 'forward') {
            return redirect('/instructor/step3')->with('jdonData', $jsonData);
        }

        return;
    }

    public function step3(Request $request)
    {
        //初期化
        $instructor = $this->instructorInit;
        $jsonData = json_encode($instructor);

        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->get('jsonData');
            $instructor = json_decode($jsonData, true);
        }

        return view('Instructor.step3', [
            'instructor' => $instructor,
            'jsonData' => $jsonData,
        ]);
    }

    public function step3Send(Request $request)
    {
        $arrData = json_decode($request->jsonData, true);
        $instructor = array_merge($arrData, $request->only($this->formItems));
        $jsonData = json_encode($instructor);

        if ($request->transition === 'back') {
            return redirect('/instructor/step2')->with('jsonData', $jsonData);
        }
        if ($request->transition === 'confirm') {
            return redirect('/instructor/confirm')->with($jsonData);
        }

        return;
    }

    public function confirm(Request $request)
    {
        $instructor = $this->instructorInit;
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
