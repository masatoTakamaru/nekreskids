<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 1) return redirect('/user/instructor/index');
        if ($user->role === 2) return redirect('/user/school/index');

        if($user->role===3){
            return view('admin.dashboard');
        }
    }
}
