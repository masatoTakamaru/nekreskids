<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KeepRecruit extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'recruit_id',
        'del_flg',

    ];


public function recruit()
{
    return $this->belongsTo(Recruit::class);
}



}