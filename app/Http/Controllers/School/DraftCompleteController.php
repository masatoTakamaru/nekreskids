<?php

namespace App\Http\Controllers\School;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Traits\SChoolTrait;

class DraftCompleteController extends Controller
{
    use SchoolTrait;

    public function index(Request $request): Response
    {
        $jsonData = $request->session()->pull('jsonData');
        $encryptedData = encrypt($jsonData);

        return response()->view("$this->dir.draft-complete")
            ->cookie($this->cookieString, $encryptedData, 6000);
    }

}
