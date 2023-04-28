<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelTrait;

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
        'name',
        'email',
        'password',
        'role',
        'status',
        'del_flg',
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
     * @return object $objResult 保存されたuserモデル
     */
    public function newEntry($jsonData, $role, $status)
    {
        $this->setAttrs(json_decode($jsonData, true));
        $this->password = bcrypt($this->password);
        $this->role = $role;
        $this->status = $status;
        $this->del_flg = 0;

        $objResult = DB::transaction(function () use ($this) {
            $arrData = $objData->toArray();
            $user = $this->create($arrData);
            $user->school()->create($arrData);
            return $user;
        });

        return $objResult;
    }
}
