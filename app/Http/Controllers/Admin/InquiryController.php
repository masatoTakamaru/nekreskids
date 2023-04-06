<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $inquiry = new Inquiry;

        if ($request->keywords) {
            $entity = $inquiry->searchEntity($request->keywords);
        } else {
            $entity = $inquiry->getEntityList();
        }

        return view('admin.inquiry.inquiry-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.inquiry.inquiry-create');
    }

    public function store(InquiryRequest $request)
    {
        $result = Inquiry::create([
            'email' => $request->email,
            'message' => $request->message,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.inquiry.inquiry-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $inquiry = new Inquiry;
        $entity = $inquiry->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.inquiry.inquiry-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $inquiry = new Inquiry;
        $entity = $inquiry->getEntity($id);

        return view('admin.inquiry.inquiry-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(InquiryRequest $request, $id)
    {
        $inquiry = new Inquiry;
        if (empty($entity)) return back()->withInput();

        $entity = $inquiry->getEntity($id);

        $result = $entity->update([
            'email' => $request->email,
            'message' => $request->message,

        ]);
        if ($result) {
            return redirect()->route('admin.inquiry.inquiry-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $inquiry = new Inquiry;
        $entity = $inquiry->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.inquiry.inquiry-index');
        } else {
            return back()->withInput();
        }
    }
}