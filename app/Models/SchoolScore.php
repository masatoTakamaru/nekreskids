<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SchoolScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'instructor_id',
        'score',
        'del_flg',

    ];


public function instructor()
{
    return $this->belongsTo(Instructor::class);
}



}