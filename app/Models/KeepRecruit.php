<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KeepRecruit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'recruit_id',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function recruit(): BelongsTo
    {
        return $this->belongsTo(Recruit::class);
    }
}