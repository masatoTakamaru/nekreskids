<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $objData = DB::table('images')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $objData->each(function($item) {
            $item->url = asset("storage/image/$item->url");
        });

        return view('index', [
            'objData' => $objData,
        ]);
    }
}
