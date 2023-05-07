<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelTrait;

class Message extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'sender',
        'recipient',
        'message',
        'read_flg',
        'del_flg',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getList($keyword): object
    {
        $query = $this->select(
            'messages.*',
            'users.id',
            'users.role'
        )
        ->leftJoin('users','messages.sender','=','users.id');

        $objData = $query->paginate(10);

        return $objData;
    }

}