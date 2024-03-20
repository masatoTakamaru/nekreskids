<?php

namespace App\Http\Controllers\User\Instructor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Models\User;
use Carbon\Carbon;

class EditController extends Controller
{
    private $dir = 'user.instructor';

    public function index(Request $request)
    {
        $endDate = $request->end_date ?? 'valid';
        $keyword = null;
        $loginUser = Auth::user();
        
        $objData = $loginUser->instructor->applications()->paginate(3);

        foreach($objData as $item)
        {
            $item->recruit->end_date = Carbon::parse($item->recruit->end_date);
        }

        return view("$this->dir.index", [
            'objData' => $objData,
            'keyword' => $keyword,
            'end_date' => $endDate,
            'genders' => UserConst::GENDER,
        ]);
    }
}
