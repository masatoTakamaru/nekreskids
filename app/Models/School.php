<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelTrait;

class School extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'name',
        'zip',
        'pref',
        'city',
        'address',
        'tel1',
        'tel2',
        'charge',
        'score',
        'del_flg',
    ];

    public function school_scores()
    {
        return $this->hasMany(SchoolScore::class);
    }

    public function recruits()
    {
        return $this->hasMany(Recruit::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ユーザー情報を保存する関数
     * 
     * @param string $jsonData json文字列化したuserとschoolモデル
     * @param string $status ステータス
     * @return object $objResult 保存されたuserモデル
     */
    public function newEntry($jsonData, $status)
    {
        $objData = new School;
        $objData->setAttrs(json_decode($jsonData, true));
        $objData->password = bcrypt($objData->password);
        $objData->role = 2;
        $objData->status = $status;
        $objData->del_flg = 0;

        $objResult = DB::transaction(function () use ($objData) {
            $model = new User;
            $arrData = $objData->toArray();
            $user = $model->create($arrData);
            $user->school()->create($arrData);
            return $user;
        });

        return $objResult;
    }

    /**
     * 学校ユーザー一覧を取得
     * @param array $keywords 絞込検索キーワード（複数）
     * @return obj
     */
    public function getList($keywords)
    {
        $query = DB::table('users')
            ->select(
                'users.*',
                'users.del_flg as u_del_flg',
                'schools.*',
                'schools.del_flg as s_del_flg',
            )
            ->leftJoin('schools', 'users.id', '=', 'schools.user_id');

        $condition = [];
        $objData = $query->where($condition)->paginate(10);

        dd($objData);
        return $objData;
    }
}
