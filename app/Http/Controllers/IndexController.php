<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $notices = Notice::orderBy('publish_date', 'desc')
            ->take(2)
            ->get();

        foreach ($notices as $item) {
            $item->content = mb_substr($item->content, 0, 20) . '…';
        }

        return view('index', [
            'notices' => $notices,
        ]);
    }
}
