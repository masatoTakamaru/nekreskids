<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KeepRecruit;
use App\Http\Controllers\Controller;

class KeepRecruitController extends Controller
{
    public function index(Request $request)
    {
        $keep_recruit = new KeepRecruit;

        if ($request->keyword) {
            $entity = $keep_recruit->searchEntity($request->keyword);
        } else {
            $entity = $keep_recruit->getEntityList();
        }

        return view('admin.keep_recruit.keep_recruit-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keyword' => $request->keyword,
        ]);
    }

    public function create()
    {
        return view('admin.keep_recruit.keep_recruit-create');
    }

    public function store(KeepRecruitRequest $request)
    {
        $result = KeepRecruit::create([
            'instructor_id' => $request->instructor_id,
            'recruit_id' => $request->recruit_id,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.keep_recruit.keep_recruit-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $keep_recruit = new KeepRecruit;
        $entity = $keep_recruit->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.keep_recruit.keep_recruit-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $keep_recruit = new KeepRecruit;
        $entity = $keep_recruit->getEntity($id);

        return view('admin.keep_recruit.keep_recruit-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(KeepRecruitRequest $request, $id)
    {
        $keep_recruit = new KeepRecruit;
        if (empty($entity)) return back()->withInput();

        $entity = $keep_recruit->getEntity($id);

        $result = $entity->update([
            'instructor_id' => $request->instructor_id,
            'recruit_id' => $request->recruit_id,

        ]);
        if ($result) {
            return redirect()->route('admin.keep_recruit.keep_recruit-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $keep_recruit = new KeepRecruit;
        $entity = $keep_recruit->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.keep_recruit.keep_recruit-index');
        } else {
            return back()->withInput();
        }
    }
}