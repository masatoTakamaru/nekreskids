<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $application = new Application;

        if ($request->keywords) {
            $entity = $application->searchEntity($request->keywords);
        } else {
            $entity = $application->getEntityList();
        }

        return view('admin.application.application-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.application.application-create');
    }

    public function store(ApplicationRequest $request)
    {
        $result = Application::create([
            'recruit_id' => $request->recruit_id,
            'instructor_id' => $request->instructor_id,
            'message' => $request->message,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.application.application-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $application = new Application;
        $entity = $application->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.application.application-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $application = new Application;
        $entity = $application->getEntity($id);

        return view('admin.application.application-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(ApplicationRequest $request, $id)
    {
        $application = new Application;
        if (empty($entity)) return back()->withInput();

        $entity = $application->getEntity($id);

        $result = $entity->update([
            'recruit_id' => $request->recruit_id,
            'instructor_id' => $request->instructor_id,
            'message' => $request->message,

        ]);
        if ($result) {
            return redirect()->route('admin.application.application-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $application = new Application;
        $entity = $application->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.application.application-index');
        } else {
            return back()->withInput();
        }
    }
}