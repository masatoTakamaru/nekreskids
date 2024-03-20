<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\CommonTrait;

class Notice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'header',
        'content',
        'publish_date',
        'status',
    ];

    
}
