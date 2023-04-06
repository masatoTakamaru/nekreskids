<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $notice = new Notice;

        if ($request->keywords) {
            $entity = $notice->searchEntity($request->keywords);
        } else {
            $entity = $notice->getEntityList();
        }

        return view('admin.notice.notice-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.notice.notice-create');
    }

    public function store(NoticeRequest $request)
    {
        $result = Notice::create([
            'header' => $request->header,
            'content' => $request->content,
            'publish_date' => $request->publish_date,
            'status' => $request->status,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.notice.notice-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $notice = new Notice;
        $entity = $notice->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.notice.notice-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $notice = new Notice;
        $entity = $notice->getEntity($id);

        return view('admin.notice.notice-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(NoticeRequest $request, $id)
    {
        $notice = new Notice;
        if (empty($entity)) return back()->withInput();

        $entity = $notice->getEntity($id);

        $result = $entity->update([
            'header' => $request->header,
            'content' => $request->content,
            'publish_date' => $request->publish_date,
            'status' => $request->status,

        ]);
        if ($result) {
            return redirect()->route('admin.notice.notice-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $notice = new Notice;
        $entity = $notice->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.notice.notice-index');
        } else {
            return back()->withInput();
        }
    }
}