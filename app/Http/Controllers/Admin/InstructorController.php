<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;
use App\Http\Controllers\Controller;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $instructor = new Instructor;

        if ($request->keywords) {
            $entity = $instructor->searchEntity($request->keywords);
        } else {
            $entity = $instructor->getEntityList();
        }

        return view('admin.instructor.instructor-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.instructor.instructor-create');
    }

    public function store(InstructorRequest $request)
    {
        $result = Instructor::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'name_kana' => $request->name_kana,
            'avatar_url' => $request->avatar_url,
            'pr' => $request->pr,
            'activities' => $request->activities,
            'other_activities' => $request->other_activities,
            'ontime' => $request->ontime,
            'act_pref1' => $request->act_pref1,
            'act_city1' => $request->act_city1,
            'act_pref2' => $request->act_pref2,
            'act_city2' => $request->act_city2,
            'act_pref3' => $request->act_pref3,
            'act_city3' => $request->act_city3,
            'act_pref4' => $request->act_pref4,
            'act_city4' => $request->act_city4,
            'act_pref5' => $request->act_pref5,
            'act_city5' => $request->act_city5,
            'gender' => $request->gender,
            'zip' => $request->zip,
            'pref' => $request->pref,
            'city' => $request->city,
            'address' => $request->address,
            'tel' => $request->tel,
            'keep' => $request->keep,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.instructor.instructor-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $instructor = new Instructor;
        $entity = $instructor->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.instructor.instructor-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $instructor = new Instructor;
        $entity = $instructor->getEntity($id);

        return view('admin.instructor.instructor-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(InstructorRequest $request, $id)
    {
        $instructor = new Instructor;
        if (empty($entity)) return back()->withInput();

        $entity = $instructor->getEntity($id);

        $result = $entity->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'name_kana' => $request->name_kana,
            'avatar_url' => $request->avatar_url,
            'pr' => $request->pr,
            'activities' => $request->activities,
            'other_activities' => $request->other_activities,
            'ontime' => $request->ontime,
            'act_pref1' => $request->act_pref1,
            'act_city1' => $request->act_city1,
            'act_pref2' => $request->act_pref2,
            'act_city2' => $request->act_city2,
            'act_pref3' => $request->act_pref3,
            'act_city3' => $request->act_city3,
            'act_pref4' => $request->act_pref4,
            'act_city4' => $request->act_city4,
            'act_pref5' => $request->act_pref5,
            'act_city5' => $request->act_city5,
            'gender' => $request->gender,
            'zip' => $request->zip,
            'pref' => $request->pref,
            'city' => $request->city,
            'address' => $request->address,
            'tel' => $request->tel,
            'keep' => $request->keep,

        ]);
        if ($result) {
            return redirect()->route('admin.instructor.instructor-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $instructor = new Instructor;
        $entity = $instructor->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.instructor.instructor-index');
        } else {
            return back()->withInput();
        }
    }
}