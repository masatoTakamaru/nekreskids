<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = new User;

        if ($request->keyword) {
            $entity = $user->searchEntity($request->keyword);
        } else {
            $entity = $user->getEntityList();
        }

        return view('admin.user.user-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keyword' => $request->keyword,
        ]);
    }

    public function create()
    {
        return view('admin.user.user-create');
    }

    public function store(UserRequest $request)
    {
        $result = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'del_flg' => 0,
        ]);

        if (!empty($result)) {
            return redirect()->route('admin.user.user-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $user = new User;
        $entity = $user->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.user.user-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $user = new User;
        $entity = $user->getEntity($id);

        return view('admin.user.user-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = new User;
        if (empty($entity)) return back()->withInput();

        $entity = $user->getEntity($id);

        $result = $entity->update([
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,

        ]);
        if ($result) {
            return redirect()->route('admin.user.user-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $user = new User;
        $entity = $user->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->update(['del_flg' => 1]);

        if () {
            return redirect()->route('admin.user.user-index');
        } else {
            return back()->withInput();
        }
    }
}