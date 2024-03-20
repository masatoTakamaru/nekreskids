<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\School;

trait SchoolTrait
{
    private $dir = 'school';
    private $cookieString = 'nekreskids_school_draft_save';
    private $model = null;
    private $attr = [
        'email',
        'password',
        'status',
        'name',
        'zip',
        'pref',
        'city',
        'address',
        'tel1',
        'tel2',
        'charge',
        'score',
    ];

    public function __construct()
    {
        $this->model = new User();
        $this->model = $this->initModel($this->model);
    }

    /**
     * モデルの初期値を設定
     * @param obj $objData モデル
     */
    private function initModel($objData): object
    {
        foreach ($this->attr as $value) {
            $objData->$value = null;
        }

        $objData->score = 0;

        return $objData;
    }

    /**
     * モデルとjsonデータを統合
     * @param obj $objData ユーザーモデル
     *        arr $jsonData jsonデータ
     */
    private function setAttr($objData, $jsonData): object
    {
        $arrData = json_decode($jsonData, true);

        foreach ($this->attr as $value) {
            $objData->$value = $arrData[$value];
        }

        return $objData;
    }

    /**
     * 入力値を統合する
     * @param $request
     */
    private function jsonInputMerge($request): string
    {
        $arrData = json_decode($request->jsonData, true);

        /*---------- 入力値を加工する場合はここに記入 ----------*/
        /*--------------------- ここまで ---------------------*/

        foreach ($this->attr as $value) {
            if ($request->has($value)) $arrData[$value] = $request->$value;
        }

        return json_encode($arrData);
    }

    /**
     * ユーザー情報を保存
     * 
     * @param string $jsonData
     * @param string $status
     */
    public function newEntry($jsonData, $status): void
    {
        $arrData = json_decode($jsonData, true);
        $arrData['password'] = bcrypt($arrData['password']);
        $arrData['role'] = 2;
        $arrData['status'] = $status;

        DB::transaction(function () use ($arrData) {

            $user = $this->model->create($arrData);
            $objSchool = new School();
            $objSchool->fill($arrData)
                ->setAttribute('user_id', $user->id)
                ->save();
        });
    }
}
