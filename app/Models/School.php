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
     * 学校ユーザー一覧
     * @param array $keywords 絞込検索キーワード（複数）
     * @return obj
     */
    public function getList($keywords)
    {
        $query = DB::table('users')
            ->select(
                'users.id',
                'users.email',
                'schools.name',
                'schools.pref',
                'schools.city',
            )
            ->leftJoin('schools', 'users.id', '=', 'schools.user_id');

        $condition = ['users.del_flg' => 0, 'schools.del_flg' => 0];
        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }

    /**
     * 学校ユーザー詳細
     * @param int $id ユーザーID
     * @return obj
     */
    public function getDetail($id)
    {
        $model = new User;
        $query = $model
            ->select(
                'users.id',
                'users.email',
                'users.password',
                'schools.name',
                'schools.zip',
                'schools.pref',
                'schools.city',
                'schools.address',
                'schools.tel1',
                'schools.tel2',
                'schools.charge',
            )
            ->leftJoin('schools', 'users.id', '=', 'schools.user_id');

            $condition = ['users.id' => $id];

        $objData = $query->where($condition)->first();

        return $objData;
    }
}
