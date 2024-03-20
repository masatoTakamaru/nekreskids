<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'name_kana',
        'avatar_url',
        'pr',
        'activities',
        'other_activities',
        'ontime',
        'act_areas',
        'birth',
        'cert',
        'gender',
        'zip',
        'pref',
        'city',
        'address',
        'tel',
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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
