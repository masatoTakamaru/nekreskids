<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Consts\RecruitConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorStep1Request;
use App\Http\Requests\InstructorStep2Request;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\Instructor;
use App\Models\User;
use Carbon\Carbon;

class InstructorController extends Controller
{
    private $objInit = null;    //初期化済みオブジェクト
    private $fillableExt = [];  //メソッド間の受け渡し項目

    public function __construct()
    {
        $model = new Instructor();
        $this->fillableExt = array_merge($model->getFillable(), [
            /*  メソッド間の受け渡し項目を追加する場合はここに記入  */
            'email',
            'password',
            'avatar',
            'actPref',
            /*  ここまで  */
        ]);
        $model->setAttrs(array_fill_keys($this->fillableExt, null));
        /*  初期値を与える場合はここに記入  */
        $model->birth = Carbon::now()->format('Y-m-d');
        $model->gender = 'male';
        $model->activities = [];
        $model->act_areas = ['1' => ['pref' => '', 'city' => '']];
        /*  ここまで  */

        $this->objInit = $model;
    }

    public function step1(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));
            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect('instructor/draft-complete')->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect('/instructor/' . $request->transit)->with('jsonData', $jsonData);
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
            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect('instructor/draft-complete')->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect('/instructor/' . $request->transit)->with('jsonData', $jsonData);
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
            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect('instructor/draft-complete')->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect('/instructor/' . $request->transit)->with('jsonData', $jsonData);
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
            'jsonActAreas' => json_encode($objData->act_areas),
            'jsonPrefs' => json_encode(['' => '選択して下さい'] + AddressConst::PREFECTURES),
            'jsonCities' => json_encode(['' => ['' => '未選択']] + AddressConst::CITIES),
        ]);
    }

    public function confirm(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $jsonData = json_encode(array_merge($arrData, $request->only($this->fillableExt)));
            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect('instructor/draft-complete')->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect('/instructor/' . $request->transit)->with('jsonData', $jsonData);
            }
        }

        //getの場合
        $jsonData = $request->session()->get('jsonData');
        $objData = new Instructor;
        $objData->setAttrs(json_decode($jsonData, true));

        /*  表示用データを整形する場合はここ  */
        $objData->gender = UserConst::GENDERS[$objData->gender];
        $objData->address = $objData->pref . $objData->city . $objData->address;
        $activities = [];
        if (!empty($objData->activities)) {
            foreach ($objData->activities as $key) {
                $activities[] = RecruitConst::ACTIVITIES[$key];
            }
            $objData->activities = implode(' ', $activities);
        }
        $actAreas = [];
        foreach ($objData->act_areas as $actArea) {
            if (!empty($acrArea['pref']) && !empty($acrArea['city'])) {
                $actAreas[] = AddressConst::PREFECTURES[$actArea['pref']] . AddressConst::CITIES[$actArea['pref']][$actArea['city']];
            }
        }
        $objData->act_areas = implode('<br>', $actAreas);
        /*  ここまで  */

        return view('Instructor.confirm', [
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
        $this->saveData($jsonData, 'public');

        return view('Instructor.complete');
    }

    public function draft_complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        //getの場合
        $jsonData = $request->session()->get('jsonData');
        $this->saveData($jsonData, 'draft');

        return view('school.draft-complete');
    }

    /**
     * ユーザー情報を保存する関数
     * 
     * @param string $jsonData json文字列化したuserとInstructorモデル
     * @param string $status ステータス
     * @return object $objResult 保存されたuserモデル
     */
    private function saveData($jsonData, $status)
    {
        $objData = new Instructor;
        $objData->setAttrs(json_decode($jsonData, true));
        $objData->password = bcrypt($objData->password);
        $objData->role = 2;
        $objData->status = $status;
        $objData->del_flg = 0;
        $objData->activities = json_encode($objData->activities);
        $objData->act_areas = json_encode($objData->act_areas);

        //アバター画像をstorageに保存
        if ($objData->avatar) {
            $data = base64_decode(str_replace('data:image/png;base64,', '', $objData->avatar));
            $fileName = Str::uuid().'.png';
            if(Storage::put("avatars/{$fileName}", $data)) {
                $objData->avatar_url = $fileName;
            }
        }

        $objResult = DB::transaction(function () use ($objData) {
            $model = new User;
            $arrData = $objData->toArray();
            $user = $model->create($arrData);
            $user->instructor()->create($arrData);
            return $user;
        });

        return $objResult;
    }
}
