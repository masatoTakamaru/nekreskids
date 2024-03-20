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
use App\Traits\CommonTrait;

class IndexController extends Controller
{
    use CommonTrait;
    
    public function index(Request $request)
    {
        $endDate = $request->end_date ?? 'valid';
        $keyword = $request->keyword;

        $objData = $this->getList($keyword, $endDate);
        $objData = $this->formatData($objData);

        $objData->appends($request->query());

        return view('user.instructor.index', [
            'objData' => $objData,
            'keyword' => $keyword,
            'end_date' => $endDate,
        ]);
    }

    /**
     * モデル取得
     * @param string $keyword   キーワード
     * @param string $endDate   期限
     */
    private function getList($keyword, $endDate): object|null
    {
        $objData = null;
        $loginUser = Auth::user();
        $query = User::query();

        $query->select(
            'recruits.id',
            'recruits.end_date',
            'recruits.header',
            'applications.message'
        )
            ->join('instructors', 'instructors.user_id', '=', 'users.id')
            ->join('applications', 'applications.instructor_id', '=', 'instructors.id')
            ->join('recruits', 'recruits.id', '=', 'applications.recruit_id')
            ->where('users.id', $loginUser->id);

        if ($endDate === 'valid') {
            $query->where('recruits.end_date', '>=', Carbon::now());
        }

        $query = $this->search($keyword, $query);

        $objData = $query->orderBy('end_date', 'asc')
            ->paginate(3);

        return $objData;
    }

    /**
     * 表示用データ整形
     * @param obj $objData
     */
    private function formatData($objData): object
    {
        foreach ($objData as $item) {
            $item->header = $this->abbrStr($item->header, 10) ?? '件名なし';
            $item->message = $this->abbrStr($item->message, 30) ?? '本文なし';
            $item->end_date = Carbon::parse($item->end_date);
        }

        return $objData;
    }

    /**
     * キーワード検索
     * @param string $keyword   キーワード
     * @param obj $query        クエリビルダ    
     */
    private function search($keyword, $query): object
    {
        $keywords = $this->splitKeyword($keyword);

        if (!$keywords) return $query;

        foreach ($keywords as $value) {
            $query->where('header', 'like', '%' . $value . '%')
                ->orWhere('message', 'like', '%' . $value . '%');
        }

        return $query;
    }
}
