<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Inquiry;

trait InquiryTrait
{
    private $dir = 'inquiry';
    private $model = null;
    private $attr = [
        'email',
        'message',
    ];

    public function __construct()
    {
        $this->model = new Inquiry();
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
     * 保存
     * @param string $jsonData
     */
    public function newEntry($jsonData): void
    {
        $arrData = json_decode($jsonData, true);

        $user = $this->model->create($arrData);
    }
}
