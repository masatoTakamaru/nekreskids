<?php

namespace App\Http\Controllers\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\User;
use App\Traits\SchoolTrait;

class ConfirmController extends Controller
{
    use SchoolTrait;

    public function index(Request $request)
    {
        $objData = $this->model;
        $jsonData = json_encode($objData);

        /*---------- セッションが存在する場合セッション値を反映 ----------*/
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->pull('jsonData');
            $objData = $this->setAttr($objData,$jsonData);
        }

        /*  表示用データを整形する場合はここ  */

        $objData->address = $objData->pref . $objData->city . $objData->address;

        /*  ここまで  */

        return view("$this->dir.confirm", [
            'objData' => $objData,
            'jsonData' => $jsonData,
        ]);
    }

    public function post(Request $request): RedirectResponse
    {
        $jsonData = $this->jsonInputMerge($request);

        //下書き保存
        if ($request->has('action') && $request->action === 'draft') {
            return redirect("/$this->dir/draft-complete")->with('jsonData', $jsonData);
        }
        //ページ遷移
        if ($request->has('transit')) {
            return redirect("/$this->dir/$request->transit")->with('jsonData', $jsonData);
        }
    }
}
