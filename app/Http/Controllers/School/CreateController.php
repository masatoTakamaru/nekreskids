<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Http\Requests\Instructor\Step1Request;
use App\Traits\SChoolTrait;
use Illuminate\Support\Facades\Storage;

class CreateController extends Controller
{
    use SchoolTrait;

    public function index(Request $request): View
    {
        $objData = $this->model;
        $jsonData = json_encode($objData);

        /*------------------- クッキーが存在する場合 --------------------*/
        $draftData = $request->cookie($this->cookieString);

        if ($draftData) {
            $jsonData = decrypt($draftData);
            $objData = $this->setAttr($objData, $jsonData);
        }

        /*---------- セッションが存在する場合セッション値を反映 ----------*/
        if ($request->session()->has('jsonData')) {
            $jsonData = $request->session()->pull('jsonData');
            $objData = $this->setAttr($objData, $jsonData);
        }

        return view("$this->dir.create", [
            'objData' => $objData,
            'jsonData' => $jsonData,
            'genders' => UserConst::GENDER,
        ]);
    }

    public function post(Request $request): RedirectResponse
    {
        $jsonData = $this->jsonInputMerge($request);

        /*---------- 下書き保存 ----------*/
        if ($request->has('action') && $request->action === 'draft') {
            return redirect("/$this->dir/draft-complete")->with('jsonData', $jsonData);
        }

        /*---------- ページ遷移 ----------*/
        if ($request->has('transit')) {
            return redirect("/$this->dir/$request->transit")->with('jsonData', $jsonData);
        }
    }
}
