<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Recruit extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
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
        'del_flg',

    ];

    public function searches()
    {
        return $this->hasMany(Search::class);
    }
    

public function school()
{
    return $this->belongsTo(School::class);
}



}