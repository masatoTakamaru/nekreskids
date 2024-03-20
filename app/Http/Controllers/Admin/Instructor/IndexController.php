<?php

namespace App\Http\Controllers\Admin\Instructor;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class IndexController extends Controller
{
    use CommonTrait;

    public function index(Request $request): View
    {
        if (Gate::denies('isAdmin')) abort(403);

        $objData = $this->getList($request->keyword);
        $objData = $this->formatData($objData);
        $objData->appends($request->query());

        return view("admin.instructor.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = User::query();

        $query->select(
            'users.id',
            'users.email',
            'instructors.name',
            'instructors.pref',
            'instructors.city',
        )
            ->join('instructors', 'users.id', '=', 'instructors.user_id')
            ->where('users.role', 1);

        if ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('email', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%');

                    $query = $this->wherePrefCity($query, $keyword);
                });
            }
        }

        $objData = $query->paginate(10);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        foreach ($objData as $item) {
            //住所
            $prefKey = $item->pref;
            $cityKey = $item->city;
            $item->pref = $this->getPref($prefKey);
            $item->city = $this->getCity($prefKey, $cityKey);
        }

        return $objData;
    }
}
