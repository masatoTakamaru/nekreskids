<?php

namespace App\Http\Controllers\Admin\Notice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Consts\NoticeConst;
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

        return view("admin.notice.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = Notice::query();

        $query->select(
            'id',
            'header',
            'content',
            'publish_date',
            'status'
        );

        if ($keywords) {
            foreach ($keywords as $item) {
                $query->where(function ($query) use ($item) {
                    $query->where('header', 'like', '%' . $item . '%')
                        ->orWhere('content', 'like', '%' . $item . '%');
                });
            }
        }

        $query->orderBy('publish_date', 'desc');

        $objData = $query->paginate(5);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        $status = NoticeConst::STATUS;

        foreach ($objData as $item) {
            $item->header = $this->abbrStr($item->header, 10);
            $item->content = $this->abbrStr($item->content, 30);
            $item->status = $status[$item->status];
        }

        return $objData;
    }
}
