<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'name_kana',
        'avatar_url',
        'pr',
        'activities',
        'other_activities',
        'ontime',
        'act_areas',
        'gender',
        'zip',
        'pref',
        'city',
        'address',
        'tel',
        'keep',
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
     * モデルのプロパティを連想配列でまとめて格納する
     */
    public function setAttrs($props): void
    {
        foreach ($props as $key => $value) {
            $this->$key = $value;
        }
    }
}
