<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Message;
use App\Models\User;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;

class MessageController extends Controller
{
    private $dir = 'message';
    private $model = ['message', 'user'];
    private $fillableExt = ['message', 'user'];

    public function __construct()
    {
        $this->model['message'] = new Message;
        $this->model['message']->setAttrs(array_fill_keys($this->model['message']->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        /*-------------------- ここまで --------------------*/

        $this->fillableExt['message'] = array_keys(collect($this->model['message'])->toArray());

        $this->model['user'] = new User;
        $this->model['user']->setAttrs(array_fill_keys($this->model['user']->getFillable(), null));

        /*-------- 項目追加・初期値の代入はここに記入 --------*/
        /*-------------------- ここまで --------------------*/

        $this->fillableExt['user'] = array_keys(collect($this->model['user'])->toArray());
    }

    public function index(Request $request): View
    {
        if (!$request->isMethod('get')) abort(404);

        $objData = null;
        $objData = $this->model['message']->getList($request->keyword);

        if (!empty($objData)) {
            foreach ($objData as $item) {
                $item = $this->getUserName($item);
            }
        }

        return view("admin.$this->dir.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    public function detail(Request $request): View|RedirectResponse
    {
        if (!$request->isMethod('get') && !$request->isMethod('delete')) abort(404);

        $objData = $this->model['message']->getDetail($request->id);
        if (empty($objData)) abort(404);

        /*--------------- deleteの場合 ---------------*/
        if ($request->isMethod('delete')) {
            $objData->deleteItem($request->id);
            return redirect("admin/$this->dir/index");
        }

        /*--------------- getの場合 ---------------*/
        $objData = $this->getUserName($objData);

        return view("admin.$this->dir.detail", [
            'objData' => $objData,
        ]);
    }

    /**
     * ユーザーIDから指導員名または学校名を取得する
     * @param obj $objData
     */

    private function getUserName($item): object
    {
        $sender = $this->model['user']->find($item->sender);
        $item->sender_name = null;

        if (!empty($sender)) {
            if ($sender->role === 1) {
                $item->sender_name = $sender->instructor->name;
            }
            if ($sender->role === 2) {
                $item->sender_name = $sender->school->name;
            }
        }

        $recipient = $this->model['user']->find($item->recipient);
        $item->recipient_name = null;

        if (!empty($recipient)) {
            if ($recipient->role === 1) {
                $item->recipient_name = $recipient->instructor->name;
            }
            if ($recipient->role === 2) {
                $item->recipient_name = $recipient->school->name;
            }
        }

        return $item;
    }
}
