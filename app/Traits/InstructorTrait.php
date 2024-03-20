<?php

namespace App\Traits;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

trait InstructorTrait
{
    private $cookieString = 'nekreskids_instructor_draft_save';

    private $attr = [
        'email',
        'password',
        'name',
        'name_kana',
        'avatar',
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
    ];

    /**
     * モデルとjsonデータを統合
     * @param obj $objData ユーザーモデル
     *        arr $jsonData jsonデータ
     */
    private function setAttr($objData, $jsonData): object
    {

        $arrData = json_decode($jsonData, true);

        foreach ($arrData as $key => $value) {
            $objData->$key = $arrData[$key];
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
        $arrData['role'] = 1;
        $arrData['status'] = $status;

        if (array_key_exists('activities', $arrData)) {
            $arrData['activities'] = json_encode($arrData['activities']);
        }

        if (array_key_exists('act_areas', $arrData)) {
            $arrData['act_areas'] = json_encode($arrData['act_areas']);
        }

        //アバター画像の処理
        if (!empty($arrData['avatar'])) {
            $arrData['avatar_url'] = $this->avatarSave($arrData['avatar']);
        }

        DB::transaction(function () use ($arrData) {

            $user = User::create($arrData);
            $user->instructor()->create($arrData);

            event(new Registered($user)); //登録メール送信
        });
    }

    /**
     * アバター画像の保存
     * @param string $avatar 画像のbase64文字列（ヘッダー無し）
     */
    private function avatarSave($avatar): string
    {

        $fileName = Str::ulid();
        $data = base64_decode(str_replace('data:image/jpeg;base64,', '', $avatar));

        if ($data) {
            Storage::put('public/avatars/' . $fileName . '.jpg', $data);
        }

        return $fileName . '.jpg';
    }
}
