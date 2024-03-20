<?php

namespace App\Http\Controllers\Admin\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\Message;
use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends Controller
{
    use CommonTrait;

    public function index(Request $request): View
    {
        $objData = $this->getList($request->keyword);
        $objData = $this->formatData($objData);
        $objData->appends($request->query());

        return view("admin.message.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = Message::query();

        $query->select(
            'messages.id',
            'messages.sender',
            'messages.recipient',
            'messages.message',
            'messages.read_flg',
            DB::raw("CASE 
                        WHEN sender_users.role = 1 THEN instructors.name
                        WHEN sender_users.role = 2 THEN schools.name
                    END AS sender_name"),
            DB::raw("CASE 
                        WHEN recipient_users.role = 1 THEN recipient_instructors.name
                        WHEN recipient_users.role = 2 THEN recipient_schools.name
                    END AS recipient_name")
        )
            ->join('users as sender_users', 'sender_users.id', '=', 'messages.sender')
            ->leftJoin('instructors', function ($join) {
                $join->on('sender_users.id', '=', 'instructors.user_id')
                    ->where('sender_users.role', '=', 1);
            })
            ->leftJoin('schools', function ($join) {
                $join->on('sender_users.id', '=', 'schools.user_id')
                    ->where('sender_users.role', '=', 2);
            })
            ->join('users as recipient_users', 'recipient_users.id', '=', 'messages.recipient')
            ->leftJoin('instructors as recipient_instructors', function ($join) {
                $join->on('recipient_users.id', '=', 'recipient_instructors.user_id')
                    ->where('recipient_users.role', '=', 1);
            })
            ->leftJoin('schools as recipient_schools', function ($join) {
                $join->on('recipient_users.id', '=', 'recipient_schools.user_id')
                    ->where('recipient_users.role', '=', 2);
            });

        // 検索
        // sender_name,recipient_nameは仮想カラムであるため
        // 再計算を行う必要がある

        if ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where(function ($query) use ($keyword) {
                        $query->where('instructors.name', 'like', '%' . $keyword . '%')
                            ->where('sender_users.role', '=', 1);
                    })
                        ->orWhere(function ($query) use ($keyword) {
                            $query->where('schools.name', 'like', '%' . $keyword . '%')
                                ->where('sender_users.role', '=', 2);
                        })
                        ->orWhere(function ($query) use ($keyword) {
                            $query->where('recipient_instructors.name', 'like', '%' . $keyword . '%')
                                ->where('recipient_users.role', '=', 1);
                        })
                        ->orWhere(function ($query) use ($keyword) {
                            $query->where('recipient_schools.name', 'like', '%' . $keyword . '%')
                                ->where('recipient_users.role', '=', 2);
                        })
                        ->orWhere('message', 'like', '%' . $keyword . '%');
                });
            }
        }

        $objData = $query->paginate(10);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        $arrRead = MessageConst::READ;

        foreach ($objData as $item) {
            $item->read_flg = $arrRead[$item->read_flg];
            $item->message = $this->abbrStr($item->message, 15);
        }

        return $objData;
    }
}
