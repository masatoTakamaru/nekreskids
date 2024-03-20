<?php

namespace App\Http\Controllers\Admin\KeepInstructor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\KeepInstructor;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends Controller
{
    use CommonTrait;

    public function index(Request $request): View
    {
        $objData = $this->getList($request->keyword);
        $objData = $this->formatData($objData);
        $objData->appends($request->query());

        return view("admin.keepInstructor.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = KeepInstructor::query();

        $query->select(
            'keep_instructors.instructor_id',
            'instructors.name',
            DB::raw('COUNT(*) as count')
        )
            ->leftJoin('instructors', 'instructors.id', '=', 'keep_instructors.instructor_id')
            ->groupBy('keep_instructors.instructor_id', 'instructors.name')
            ->orderBy('count', 'desc');

        $objData = $query->paginate(10);

        // 検索

        if ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
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
        return $objData;
    }
}
