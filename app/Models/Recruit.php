<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\ModelTrait;
use App\Consts\AddressConst;
use App\Consts\RecruitConst;
use App\Models\School;

class Recruit extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'header',
        'pr',
        'recruit_type',
        'activities',
        'other_activities',
        'ontime',
        'payment_type',
        'payment',
        'commutation_type',
        'commutation',
        'number',
        'status',
        'end_date',
        'keep',
        'del_flg',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function searches()
    {
        return $this->hasMany(Search::class);
    }


    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * 指導員募集の新規作成
     * 
     * @param string $jsonData
     */
    public function newEntry($jsonData): object
    {
        $objData = [];
        $arrTemp = json_decode($jsonData, true);
        $arrData = array_replace($arrTemp, [
            'activities' => json_encode($arrTemp['activities']),
            'del_flg' => 0,
        ]);
        $school = School::find($arrData['school_id']);

        if (!empty($school)) {
            $objData = $school->recruits()->create($arrData);
        }

        return $objData;
    }

    /**
     * 指導員募集更新
     * @param array $arrData フォームで入力されたデータ
     */
    public function updateData($arrData): void
    {
        $objData = $this->find($arrData['id']);
        $objData->fill($arrData)
            ->save();
    }

    /**
     * 指導員募集削除
     * @param int $id
     */
    public function deleteData($id): void
    {
        $objData = $this->find($id);

        if (!empty($objData)) {
            $objData->fill(['del_flg' => 1])->save();
        }
    }

    /**
     * 指導員募集一覧
     * @param string $keyword 絞込検索キーワード（複数）
     */
    public function getList($keyword): object
    {
        $pref = AddressConst::PREFECTURE;
        $prefCity = AddressConst::CITIES;
        $activity = RecruitConst::ACTIVITY;

        $query = $this->select(
            'r.*',
            's.name as school_name',
        )
            ->from('recruits as r')
            ->leftJoin('schools as s', 'r.school_id', '=', 's.id');

        if (!empty($keyword)) {

            $arrKeyword = $this->splitKeyword($keyword);

            foreach ($arrKeyword as $search) {

                $query->where(function ($query)
                use ($search, $pref, $prefCity, $activity) {

                    // 件名・学校名で検索
                    $query->where('r.header', 'LIKE', "%$search%")
                        ->orWhere('s.name', 'LIKE', "%$search%");

                    // 都道府県で検索
                    $prefTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $pref);
                    $prefMatch = array_keys($prefTemp);

                    foreach ($prefMatch as $value) {
                        $query->orWhere('s.pref', 'LIKE', "%$value%");
                    }

                    // 市区町村で検索
                    $cityMatch = [];
                    foreach ($prefCity as $value) {
                        $cityTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $value);
                        $cityMatch = array_merge($cityMatch, array_keys($cityTemp));
                    }

                    foreach ($cityMatch as $value) {
                        $query->orWhere('s.city', 'LIKE', "%$value%");
                    }

                    // 活動名で検索
                    $actTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $activity);
                    $actMatch = array_keys($actTemp);

                    foreach ($actMatch as $value) {
                        $query->orWhere('r.activities', 'LIKE', "%$value%");
                    }

                });
            }
        }

        $condition = ['r.del_flg' => 0, 's.del_flg' => 0];

        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }

    /**
     * 指導員募集詳細
     * @param int $id ユーザーID
     */
    public function getDetail($id): object
    {
        $query = $this->select(
            'r.*',
            's.name as school_name',
        )
            ->from('recruits as r')
            ->leftJoin('schools as s', 'r.school_id', '=', 's.id');

        $condition = ['r.id' => $id];
        $objData = $query->where($condition)->first();

        return $objData;
    }
}
