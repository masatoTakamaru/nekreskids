<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'header',
        'content',
        'publish_date',
        'status',
        'del_flg',

    ];




}