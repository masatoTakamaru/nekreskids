<?php

namespace App\Http\Controllers\Admin\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Consts\MessageConst;
use App\Traits\CommonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShowController extends Controller
{
    use CommonTrait;

    public function show(Request $request): View
    {
        $objData = $this->getEntity($request->id);
        if (empty($objData)) abort(404);

        $objData = $this->formatData($objData);

        return view("admin.message.show", [
            'objData' => $objData,
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $objData = Message::find($request->id);

        if ($objData) $objData->delete();

        return redirect("admin/message/index")
            ->with('flash', '削除しました');
    }

    private function getEntity($id): object|null
    {
        $objData = Message::select(
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
            })
            ->where('messages.id', $id)
            ->first();
        return $objData;
    }

    private function formatData($objData): object
    {
        $arrRead = MessageConst::READ;

        $objData->read_flg = $arrRead[$objData->read_flg];

        return $objData;
    }
}
