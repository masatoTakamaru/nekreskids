<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    use HasFactory;

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
     * モデルのプロパティを連想配列でまとめて格納する
     */
    public function setAttrs($attrs): void
    {
        foreach ($attrs as $key => $value) {
            $this->$key = $value;
        }
    }
}
