<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $message = new Message;

        if ($request->keywords) {
            $entity = $message->searchEntity($request->keywords);
        } else {
            $entity = $message->getEntityList();
        }

        return view('admin.message.message-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.message.message-create');
    }

    public function store(MessageRequest $request)
    {
        $result = Message::create([
            'sender' => $request->sender,
            'recipient' => $request->recipient,
            'message' => $request->message,
            'read_flg' => $request->read_flg,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.message.message-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $message = new Message;
        $entity = $message->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.message.message-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $message = new Message;
        $entity = $message->getEntity($id);

        return view('admin.message.message-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(MessageRequest $request, $id)
    {
        $message = new Message;
        if (empty($entity)) return back()->withInput();

        $entity = $message->getEntity($id);

        $result = $entity->update([
            'sender' => $request->sender,
            'recipient' => $request->recipient,
            'message' => $request->message,
            'read_flg' => $request->read_flg,

        ]);
        if ($result) {
            return redirect()->route('admin.message.message-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $message = new Message;
        $entity = $message->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.message.message-index');
        } else {
            return back()->withInput();
        }
    }
}