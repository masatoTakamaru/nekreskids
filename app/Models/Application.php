<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruit_id',
        'instructor_id',
        'message',
        'del_flg',

    ];


public function instructor()
{
    return $this->belongsTo(Instructor::class);
}



}