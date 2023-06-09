<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelTrait;
use App\Consts\AddressConst;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function school()
    {
        return $this->hasOne(School::class);
    }

    /**
     * ユーザー情報を保存する関数
     * 
     * @param string $jsonData json文字列化したuserとschoolモデル
     * @param string $status ステータス
     */
    public function newEntry($jsonData, $role, $status): object
    {
        $arrTemp = json_decode($jsonData, true);
        $arrData = array_replace($arrTemp, [
            'password' => bcrypt($arrTemp['password']),
            'role' => $role,
            'status' => $status,
            'del_flg' => 0,
        ]);

        $objData = DB::transaction(function () use ($arrData) {

            if ($arrData['role'] === 1) {

                //アバター画像の保存
                if (!empty($arrData['avatar'])) {
                    $dirName = 'avatars';
                    $fileName = Str::ulid();
                    $arrData['avatar_url'] = $fileName;
                    $data = base64_decode(str_replace('data:image/png;base64,', '', $arrData['avatar']));
                    Storage::put("$dirName/$fileName.png", $data);
                }

                $arrData = array_replace($arrData, [
                    'activities' => json_encode($arrData['activities']),
                    'act_areas' => json_encode($arrData['act_areas']),
                ]);
                $user = $this->create($arrData);
                $objData = $user->instructor()->create($arrData);
                return $objData;
            }

            if ($arrData['role'] === 2) {
                $user = $this->create($arrData);
                $objData = $user->school()->create($arrData);
                return $objData;
            }
        });

        return $objData;
    }

    /**
     * 指導員ユーザー更新
     * @param array $arrData フォームで入力されたデータ
     */
    public function updateInstructorUser($arrData): void
    {
        if (!empty($arrData['password'])) {
            $arrData['password'] = bcrypt($arrData['password']);
        }

        $objData = $this->find($arrData['id']);
        $objData->fill($arrData)
            ->save();
        $objData->school
            ->fill($arrData)
            ->save();
    }

    /**
     * 指導員ユーザー削除
     * @param int $id ユーザーID
     */
    public function deleteInstructorUser($id): void
    {
        $objData = $this->find($id);
        if (!empty($objData)) {
            $objData->fill(['del_flg' => 1])
                ->save();
            $objData->school
                ->fill(['del_flg' => 1])
                ->save();
        }
    }

    /**
     * 指導員ユーザー一覧
     * @param string $keyword 絞込検索キーワード（複数）
     */
    public function getInstructorUserList($keyword): object
    {
        $prefs = AddressConst::PREFECTURE;
        $prefCities = AddressConst::CITIES;

        $query = $this->select(
            'u.id',
            'u.email',
            'i.name',
            'i.pref',
            'i.city',
        )
            ->from('users as u')
            ->leftJoin('instructors as i', 'users.id', '=', 'instructors.user_id');

        if (!empty($keyword)) {

            $arrKeyword = $this->splitKeyword($keyword);

            foreach ($arrKeyword as $search) {

                $query->where(function ($query) use ($search, $prefs, $prefCities) {

                    //名前とメールアドレスで検索
                    $query->where('is.name', 'LIKE', "%$search%")
                        ->orWhere('u.email', 'LIKE', "%$search%");

                    //都道府県で検索
                    $prefTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $prefs);
                    $prefMatches = array_keys($prefTemp);

                    foreach ($prefMatches as $pref) {
                        $query->orWhere('i.pref', 'LIKE', "%$pref%");
                    }

                    //市区町村で検索
                    $cityMatches = [];
                    foreach ($prefCities as $cities) {
                        $cityTemp = preg_grep('/' . preg_quote($search, '/') . '/u', $cities);
                        $cityMatches = array_merge($cityMatches, array_keys($cityTemp));
                    }

                    foreach ($cityMatches as $city) {
                        $query->orWhere('i.city', 'LIKE', "%$city%");
                    }
                });
            }
        }

        $condition = ['u.del_flg' => 0, 'i.del_flg' => 0];
        //dd(preg_replace_array('/\?/', $query->getBindings(), $query->toSql()));

        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }

    /**
     * 指導員ユーザー詳細
     * @param int $id ユーザーID
     */
    public function getInstructorUserDetail($id): object
    {
        $objData = null;

        $query = $this->select(
            'i.*',
            'u.email',
            'u.status',
        )
            ->from('users as u')
            ->leftJoin('instructors as i', 'u.id', '=', 'i.user_id');

        $condition = ['u.id' => $id];
        $objData = $query->where($condition)->first();

        return !empty($objData) ? $objData : null;
    }

    /**
     * 学校ユーザー更新
     * @param array $arrData フォームで入力されたデータ
     */
    public function updateSchoolUser($arrData): void
    {
        if (!empty($arrData['password'])) {
            $arrData['password'] = bcrypt($arrData['password']);
        }

        $objData = $this->find($arrData['id']);
        $objData->fill($arrData)
            ->save();
        $objData->school
            ->fill($arrData)
            ->save();
    }

    /**
     * 学校ユーザー削除
     * @param int $id ユーザーID
     */
    public function deleteSchoolUser($id): void
    {
        $objData = $this->find($id);
        if (!empty($objData)) {
            $objData->fill(['del_flg' => 1])
                ->save();
            $objData->school
                ->fill(['del_flg' => 1])
                ->save();
        }
    }

    /**
     * 学校ユーザー一覧
     * @param array $keyword 絞込検索キーワード（複数）
     */
    public function getSchoolUserList($keyword): object
    {
        $query = $this->select(
            'u.id',
            'u.email',
            's.name',
            's.pref',
            's.city',
        )
            ->from('users as u')
            ->leftJoin('schools as s', 'u.id', '=', 's.user_id');

        $condition = ['u.del_flg' => 0, 's.del_flg' => 0];
        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }

    /**
     * 学校ユーザー詳細
     * @param int $id ユーザーID
     */
    public function getSchoolUserDetail($id): object
    {
        $query = $this->select(
            'u.id',
            'u.email',
            's.id as school_id',
            's.name',
            's.zip',
            's.pref',
            's.city',
            's.address',
            's.tel1',
            's.tel2',
            's.charge',
        )
            ->from('users as u')
            ->leftJoin('schools as s', 'u.id', '=', 's.user_id');

        $condition = ['users.id' => $id];
        $objData = $query->where($condition)->first();

        return $objData;
    }
}
