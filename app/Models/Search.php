<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'recruit_id',
        'schooLid',

    ];


public function recruit()
{
    return $this->belongsTo(Recruit::class);
}



}