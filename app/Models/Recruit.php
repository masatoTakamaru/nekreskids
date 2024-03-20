<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'header',
        'pr',
        'recruit_type',
        'activities',
        'other_activities',
        'ontime',
        'payment_type',
        'payment',
        'commutation_type',
        'commutation',
        'number',
        'status',
        'end_date',
        'keep',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function keepInstructors(): HasMany
    {
        return $this->hasMany(KeepInstructor::class);
    }

    public function keepRecruits(): HasMany
    {
        return $this->hasMany(KeepRecruit::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

}
