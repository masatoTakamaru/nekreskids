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

    public function create(Request $request)
    {
        return view('admin.school.school-create');
    }

    public function detail(Request $request, $id)
    {
        $school = new School;
        $entity = $school->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.school.school-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit(Request $request, $id)
    {
        $school = new School;
        $entity = $school->getEntity($id);

        return view('admin.school.school-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }
}