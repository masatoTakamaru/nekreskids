<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Search;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = new Search;

        if ($request->keywords) {
            $entity = $search->searchEntity($request->keywords);
        } else {
            $entity = $search->getEntityList();
        }

        return view('admin.search.search-index', [
            'objData' => !empty($entity) ? $entity : null,
            'keywords' => $request->keywords,
        ]);
    }

    public function create()
    {
        return view('admin.search.search-create');
    }

    public function store(SearchRequest $request)
    {
        $result = Search::create([
            'instructor_id' => $request->instructor_id,
            'recruit_id' => $request->recruit_id,
            'schooLid' => $request->schooLid,

        ]);

        if (!empty($result)) {
            return redirect()->route('admin.search.search-index');
        } else {
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $search = new Search;
        $entity = $search->getEntity($id);
        if (empty($entity)) return back()->withInput();

        return view('admin.search.search-show', [
            'objData' => $entity,
        ]);        
    }

    public function edit($id)
    {
        $search = new Search;
        $entity = $search->getEntity($id);

        return view('admin.search.search-edit', [
            'objData' => empty($entity) ? null : $entity,
        ]);
    }

    public function update(SearchRequest $request, $id)
    {
        $search = new Search;
        if (empty($entity)) return back()->withInput();

        $entity = $search->getEntity($id);

        $result = $entity->update([
            'instructor_id' => $request->instructor_id,
            'recruit_id' => $request->recruit_id,
            'schooLid' => $request->schooLid,

        ]);
        if ($result) {
            return redirect()->route('admin.search.search-index');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $search = new Search;
        $entity = $search->getEntity($id);
        if (empty($entity)) return back()->withInput();
    
        $result = $entity->destroy();

        if () {
            return redirect()->route('admin.search.search-index');
        } else {
            return back()->withInput();
        }
    }
}