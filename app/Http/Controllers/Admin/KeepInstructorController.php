<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KeepInstructor;
use App\Http\Controllers\Controller;

class KeepInstructorController extends Controller
{
    public function index(Request $request)
    {
        $keep_instructor = new KeepInstructor;

        if ($request->keywords) {
            $entity = $keep_instructor->searchEntity($request->keywords);
        } else {
            $entity = $keep_instructor->getEntityList();
        }

        return view('admin.keep_instructor.keep_instructor-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.keep_instructor.keep_instructor-create');
    }

    public function store(KeepInstructorRequest $request)
    {
        $result = KeepInstructor::create([
            'school_id' => $request->school_id,
            'instructor_id' => $request->instructor_id,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.keep_instructor.keep_instructor-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $keep_instructor = new KeepInstructor;
        $entity = $keep_instructor->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.keep_instructor.keep_instructor-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $keep_instructor = new KeepInstructor;
        $entity = $keep_instructor->getEntity($id);

        return view('admin.keep_instructor.keep_instructor-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(KeepInstructorRequest $request, $id)
    {
        $keep_instructor = new KeepInstructor;
        if (empty($entity)) return back()->withInput();

        $entity = $keep_instructor->getEntity($id);

        $result = $entity->update([
            'school_id' => $request->school_id,
            'instructor_id' => $request->instructor_id,

        ]);
        if ($result) {
            return redirect()->route('admin.keep_instructor.keep_instructor-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $keep_instructor = new KeepInstructor;
        $entity = $keep_instructor->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.keep_instructor.keep_instructor-index');
        } else {
            return back()->withInput();
        }
    }
}