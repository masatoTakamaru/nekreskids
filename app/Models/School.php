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

}
