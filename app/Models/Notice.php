<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelTrait;

class Notice extends Model
{
    use HasFactory;
    use ModelTrait;

    protected $fillable = [
        'header',
        'content',
        'publish_date',
        'status',
        'del_flg',

    ];

    public function getList($keyword): object
    {

        $query = $this->select(
            'notices.*',
        )
            ->from('notices');

        $condition = ['del_flg' => 0];
        $objData = $query->where($condition)->paginate(10);

        return $objData;
    }

    public function getDetail($id): object
    {
        $objData = $this->find($id);

        return !empty($objData) ? $objData : null;
    }

    public function deleteItem($id): void
    {
        $objData = $this->find($id);
        $condition = ['del_flg' => 1];

        if (!empty($objData)) {
            $objData->fill($condition)->save();
        }
    }
}
