<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Recruit;
use App\Http\Controllers\Controller;

class RecruitController extends Controller
{
    public function index(Request $request)
    {
        $recruit = new Recruit;

        if ($request->keywords) {
            $entity = $recruit->searchEntity($request->keywords);
        } else {
            $entity = $recruit->getEntityList();
        }

        return view('admin.recruit.recruit-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.recruit.recruit-create');
    }

    public function store(RecruitRequest $request)
    {
        $result = Recruit::create([
            'school_id' => $request->school_id,
            'header' => $request->header,
            'pr' => $request->pr,
            'recruit_type' => $request->recruit_type,
            'activities' => $request->activities,
            'other_activities' => $request->other_activities,
            'ontime' => $request->ontime,
            'payment_type' => $request->payment_type,
            'payment' => $request->payment,
            'commutation_type' => $request->commutation_type,
            'commutation' => $request->commutation,
            'number' => $request->number,
            'status' => $request->status,
            'end_date' => $request->end_date,
            'keep' => $request->keep,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.recruit.recruit-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $recruit = new Recruit;
        $entity = $recruit->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.recruit.recruit-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $recruit = new Recruit;
        $entity = $recruit->getEntity($id);

        return view('admin.recruit.recruit-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(RecruitRequest $request, $id)
    {
        $recruit = new Recruit;
        if (empty($entity)) return back()->withInput();

        $entity = $recruit->getEntity($id);

        $result = $entity->update([
            'school_id' => $request->school_id,
            'header' => $request->header,
            'pr' => $request->pr,
            'recruit_type' => $request->recruit_type,
            'activities' => $request->activities,
            'other_activities' => $request->other_activities,
            'ontime' => $request->ontime,
            'payment_type' => $request->payment_type,
            'payment' => $request->payment,
            'commutation_type' => $request->commutation_type,
            'commutation' => $request->commutation,
            'number' => $request->number,
            'status' => $request->status,
            'end_date' => $request->end_date,
            'keep' => $request->keep,

        ]);
        if ($result) {
            return redirect()->route('admin.recruit.recruit-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $recruit = new Recruit;
        $entity = $recruit->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.recruit.recruit-index');
        } else {
            return back()->withInput();
        }
    }
}