<?php

namespace App\Http\Controllers\Admin\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
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

        return view("admin.application.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
            'end_date' => $request->end_date ?? 'all',
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = Application::query();

        $query->select(
            'applications.id',
            'applications.recruit_id',
            'applications.instructor_id',
            'applications.message',
            'schools.name',
            'recruits.header',
            'recruits.end_date',
            'instructors.name as instructor_name',
            'instructors.user_id'
        )
            ->join('recruits', 'recruits.id', '=', 'applications.recruit_id')
            ->join('instructors', 'instructors.id', '=', 'applications.instructor_id')
            ->join('schools', 'schools.id', '=', 'recruits.school_id')
            ->orderBy('recruits.end_date', 'desc')
            ->orderBy('instructors.name', 'desc');

        if ($keywords) {
            foreach ($keywords as $item) {
                $query->where(function ($query) use ($item) {
                    $query->where('applications.message', 'like', '%' . $item . '%')
                        ->orWhere('schools.name', 'like', '%' . $item . '%')
                        ->orWhere('instructors.name', 'like', '%' . $item . '%');
                });
            }
        }

        $objData = $query->paginate(5);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        foreach ($objData as $item) {
            $item = $this->fillStr($item, '未入力');
            $item->header = $this->abbrStr($item->header, 15);
            $item->message = $this->abbrStr($item->message, 20);
        }

        return $objData;
    }
}
