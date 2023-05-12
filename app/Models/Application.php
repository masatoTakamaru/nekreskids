<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelTrait;
use Carbon\Carbon;

class Application extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'message',
        'del_flg',

    ];

    public function recruit()
    {
        return $this->belongsTo(Recruit::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * 指導員募集一覧
     * @param string $keyword 絞込検索キーワード（複数）
     */
    public function getList($keyword, $end_date): object
    {
        $query = $this->select(
            'a.*',
            'r.header as recruit_header',
            'r.end_date',
            'i.name as instructor_name'
        )
            ->from('applications as a')
            ->leftJoin('recruits as r', 'a.recruit_id', '=', 'r.id')
            ->leftJoin('instructors as i', 'a.instructor_id', '=', 'i.id');

        /*
        if (!empty($keyword)) {

            $arrKeyword = $this->splitKeyword($keyword);

            foreach ($arrKeyword as $search) {

                $query->where(function ($query) use ($search, $pref, $prefCity) {

                    //件名・学校名で検索
                    $query->where('recruits.header', 'LIKE', "%$search%")
                        ->orWhere('schools.name', 'LIKE', "%$search%");

                    //都道府県で検索
                    $prefTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $pref);
                    $prefMatch = array_keys($prefTemp);

                    foreach ($prefMatch as $value) {
                        $query->orWhere('schools.pref', 'LIKE', "%$value%");
                    }

                    //市区町村で検索
                    $cityMatch = [];
                    foreach ($prefCity as $value) {
                        $cityTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $value);
                        $cityMatch = array_merge($cityMatch, array_keys($cityTemp));
                    }

                    foreach ($cityMatch as $value) {
                        $query->orWhere('schools.city', 'LIKE', "%$value%");
                    }
                });
            }
        }
        */

        if ($end_date === 'before') {
            $today = Carbon::today();
            $query->whereDate('r.end_date', '>=', $today);
        }

        $condition = [
            'a.del_flg' => 0,
            'r.del_flg' => 0,
            'i.del_flg' => 0,
        ];
        //dd(preg_replace_array('/\?/', $query->getBindings(), $query->toSql()));

        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }
}
