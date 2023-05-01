<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\User;
use App\Http\Requests\InstructorStep3Request;
use Carbon\Carbon;

class InstructorController extends Controller
{
    private $model = null;
    private $dir = 'instructor';
    private $fillableExt = [];  //メソッド間の受け渡し項目

    public function __construct()
    {
        $this->model = new User;
        $this->fillableExt = array_merge($this->model->getFillable(), [
            /*-- メソッド間の受け渡し項目を追加する場合はここに記入 --*/
            'name',
            'name_kana',
            'avatar_url',
            'pr',
            'activities',
            'other_activities',
            'ontime',
            'act_areas',
            'birth',
            'cert',
            'gender',
            'zip',
            'pref',
            'city',
            'address',
            'tel',
            'keep',
            'avatar',
            /*--------------------- ここまで ---------------------*/
        ]);
        $this->model->setAttrs(array_fill_keys($this->fillableExt, null));

        /*---------- 初期値を与える場合はここに記入 ----------*/
        $this->model->birth = Carbon::now()->format('Y-m-d');
        $this->model->gender = 'male';
        $this->model->activities = [];
        $this->model->act_areas = ['1' => ['pref' => '', 'city' => '']];
        /*-------------------- ここまで --------------------*/
    }

    public function step1(Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $input = $request->only($this->fillableExt);
            /*---------- 入力値を加工する場合はここに記入 ----------*/
            /*--------------------- ここまで ---------------------*/
            $jsonData = json_encode(array_merge($arrData, $input));

            /*---------- 下書き保存 ----------*/
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("/$this->dir/draft-complete")->with('jsonData', $jsonData);
            }

            /*---------- ページ遷移 ----------*/
            if ($request->has('transit')) {
                return redirect("/$this->dir/$request->transit")->with('jsonData', $jsonData);
            }
        }

        /*---------- getの場合 ----------*/
        $objData = $this->model;
        $jsonData = json_encode($objData);

        /*---------- セッションが存在する場合セッション値を反映 ----------*/
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->pull('jsonData');
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view("$this->dir.step1", [
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
            $input = $request->only($this->fillableExt);
            /*---------- 入力値を加工する場合はここに記入 ----------*/
            /*--------------------- ここまで ---------------------*/

            $jsonData = json_encode(array_merge($arrData, $input));

            /*---------- 下書き保存 ----------*/
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("$this->dir/draft-complete")->with('jsonData', $jsonData);
            }

            /*---------- ページ遷移 ----------*/
            if ($request->has('transit')) {
                return redirect("/$this->dir/$request->transit")->with('jsonData', $jsonData);
            }
        }

        /*---------- getの場合 ----------*/
        $objData = $this->model;
        $jsonData = json_encode($objData);
        /*---------- セッションが存在する場合セッション値を反映 ----------*/
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->pull('jsonData');
            $objData->setAttrs(json_decode($jsonData, true));
        }

        return view("$this->dir.step2", [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function step3(InstructorStep3Request $request)
    {
        if (!$request->isMethod('get') && !$request->isMethod('post')) abort(404);

        if ($request->isMethod('post')) {
            $arrData = json_decode($request->jsonData, true);
            $input = $request->only($this->fillableExt);
            /*---------- 入力値を加工する場合はここに記入 ----------*/
            $arrTemp = [];
            if (!empty($input['activities'])) {
                $arrTemp = array_values($input['activities']);
            }
            $input['activities'] = $arrTemp;
            /*--------------------- ここまで ---------------------*/
            $jsonData = json_encode(array_merge($arrData, $input));

            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("$this->dir/draft-complete")->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect("/$this->dir/" . $request->transit)->with('jsonData', $jsonData);
            }
        }

        //getの場合
        $objData = $this->model;
        $jsonData = json_encode($objData);
        //セッションが存在する場合セッション値を反映
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->pull('jsonData');
            $objData->setAttrs(json_decode($jsonData, true));
        }
        return view("$this->dir.step3", [
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
            $input = $request->only($this->fillableExt);
            /*---------- 入力値を加工する場合はここに記入 ----------*/
            /*--------------------- ここまで ---------------------*/

            $jsonData = json_encode(array_merge($arrData, $input));

            //下書き保存
            if ($request->has('action') && $request->action === 'draft') {
                return redirect("/$this->dir/draft-complete")->with('jsonData', $jsonData);
            }
            //ページ遷移
            if ($request->has('transit')) {
                return redirect("/$this->dir/$request->transit")->with('jsonData', $jsonData);
            }
        }

        //getの場合
        $objData = $this->model;
        $jsonData = $request->session()->pull('jsonData');
        $objData->setAttrs(json_decode($jsonData, true));

        /*  表示用データを整形する場合はここ  */
        $objData->gender = UserConst::GENDERS[$objData->gender];
        $objData->address = $objData->pref . $objData->city . $objData->address;
        $activities = [];
        if (!empty($objData->activities)) {
            foreach ($objData->activities as $value) {
                $activities[] = RecruitConst::ACTIVITIES[$value];
            }
            $objData->activities = implode(' ', $activities);
        }
        if (empty($objData->activities)) {
            $objData->activities = '';
        }
        $actAreas = [];
        foreach ($objData->act_areas as $actArea) {
            if (!empty($acrArea['pref']) && !empty($acrArea['city'])) {
                $actAreas[] = AddressConst::PREFECTURES[$actArea['pref']] . AddressConst::CITIES[$actArea['pref']][$actArea['city']];
            }
        }
        $objData->act_areas = implode('<br>', $actAreas);
        /*  ここまで  */

        return view("$this->dir.confirm", [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        //getの場合
        $jsonData = $request->session()->pull('jsonData');
        $objData = $this->model;
        $objData->newEntry($jsonData, 1, 'public');

        return view("$this->dir.complete");
    }

    public function draft_complete(Request $request)
    {
        if (!$request->isMethod('get')) abort(404);
        if ($request->isMethod('get') && !$request->session()->has('jsonData')) abort(404);

        //getの場合
        $jsonData = $request->session()->pull('jsonData');
        $objData = $this->model;
        $objData->newEntry($jsonData, 1, 'draft');

        return view("$this->dir.draft-complete");
    }
}
