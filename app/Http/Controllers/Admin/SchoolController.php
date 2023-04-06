<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $school = new School;

        if ($request->keywords) {
            $entity = $school->searchEntity($request->keywords);
        } else {
            $entity = $school->getEntityList();
        }

        return view('admin.school.school-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.school.school-create');
    }

    public function store(SchoolRequest $request)
    {
        $result = School::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'zip' => $request->zip,
            'pref' => $request->pref,
            'city' => $request->city,
            'address' => $request->address,
            'tel1' => $request->tel1,
            'tel2' => $request->tel2,
            'charge' => $request->charge,
            'score' => $request->score,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.school.school-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $school = new School;
        $entity = $school->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.school.school-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $school = new School;
        $entity = $school->getEntity($id);

        return view('admin.school.school-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(SchoolRequest $request, $id)
    {
        $school = new School;
        if (empty($entity)) return back()->withInput();

        $entity = $school->getEntity($id);

        $result = $entity->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'zip' => $request->zip,
            'pref' => $request->pref,
            'city' => $request->city,
            'address' => $request->address,
            'tel1' => $request->tel1,
            'tel2' => $request->tel2,
            'charge' => $request->charge,
            'score' => $request->score,

        ]);
        if ($result) {
            return redirect()->route('admin.school.school-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $school = new School;
        $entity = $school->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.school.school-index');
        } else {
            return back()->withInput();
        }
    }
}