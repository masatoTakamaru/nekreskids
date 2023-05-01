<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $notices = Notice::orderBy('publish_date', 'desc')
            ->take(2)->get();
        if(!empty($notices)) {
            $notices->each(function ($notice) {
                if (mb_strlen($notice->content) > 30) {
                    $notice->content = mb_substr($notice->content, 0, 30, 'UTF-8') . '…';
                }
            });    
        }
        return view('index', compact('notices'));
    }
}
