<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelTrait;
use Carbon\Carbon;

class Image extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'url',
        'tag',
    ];
}
