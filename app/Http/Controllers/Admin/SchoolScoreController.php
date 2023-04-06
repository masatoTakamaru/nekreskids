<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolScore;
use App\Http\Controllers\Controller;

class SchoolScoreController extends Controller
{
    public function index(Request $request)
    {
        $school_score = new SchoolScore;

        if ($request->keywords) {
            $entity = $school_score->searchEntity($request->keywords);
        } else {
            $entity = $school_score->getEntityList();
        }

        return view('admin.school_score.school_score-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.school_score.school_score-create');
    }

    public function store(SchoolScoreRequest $request)
    {
        $result = SchoolScore::create([
            'school_id' => $request->school_id,
            'instructor_id' => $request->instructor_id,
            'score' => $request->score,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.school_score.school_score-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $school_score = new SchoolScore;
        $entity = $school_score->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.school_score.school_score-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $school_score = new SchoolScore;
        $entity = $school_score->getEntity($id);

        return view('admin.school_score.school_score-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(SchoolScoreRequest $request, $id)
    {
        $school_score = new SchoolScore;
        if (empty($entity)) return back()->withInput();

        $entity = $school_score->getEntity($id);

        $result = $entity->update([
            'school_id' => $request->school_id,
            'instructor_id' => $request->instructor_id,
            'score' => $request->score,

        ]);
        if ($result) {
            return redirect()->route('admin.school_score.school_score-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $school_score = new SchoolScore;
        $entity = $school_score->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.school_score.school_score-index');
        } else {
            return back()->withInput();
        }
    }
}