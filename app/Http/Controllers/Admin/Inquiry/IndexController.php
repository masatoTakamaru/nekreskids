<?php

namespace App\Http\Controllers\Admin\Inquiry;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\View\View;
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

        return view("admin.inquiry.index", [
            'objData' => $objData,
            'keyword' => $request->keyword,
        ]);
    }

    private function getList($keyword): object
    {
        $keywords = $this->splitKeyword($keyword);
        $query = Inquiry::query();

        $query->select(
            'id',
            'email',
            'message',
        );

        if ($keywords) {
            foreach ($keywords as $item) {
                $query->where(function ($query) use ($item) {
                    $query->where('message', 'like', '%' . $item . '%')
                        ->orWhere('email', 'like', '%' . $item . '%');
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
            $item->message = $this->abbrStr($item->message, 20);
        }

        return $objData;
    }
}
