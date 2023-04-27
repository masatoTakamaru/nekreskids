<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\ModelTrait;

class Instructor extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        //'user_id',
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
        'del_flg',
    ];

    public function searches()
    {
        return $this->hasMany(Search::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ユーザー情報を保存する関数
     * 
     * @param string $jsonData json文字列化したuserとInstructorモデル
     * @param string $status ステータス
     * @return object $objResult 保存されたuserモデル
     */
    public function newEntry($jsonData, $status)
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
