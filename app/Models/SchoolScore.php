<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SchoolScore extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'instructor_id',
        'score',
    ];

    public function school():BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function instructor():BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }
}