<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'recipient',
        'message',
        'read_flg',

    ];




}