<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\SChoolTrait;

class CompleteController extends Controller
{
    use SchoolTrait;

    public function index(Request $request): Response
    {
        $jsonData = $request->session()->pull('jsonData');
        $this->newEntry($jsonData, 'public');

        return response()->view("$this->dir.complete")
            //下書き保存用クッキーを削除
            ->cookie($this->cookieString, '', 0);
    }
}
