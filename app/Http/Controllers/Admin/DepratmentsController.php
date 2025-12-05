<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depratments;

class DepratmentsController extends Controller
{

        public function index()
    {
        $items = Depratments::all();
        return view('pages.depratments.index', compact('items'));
    }


        public function create()
    {
        return view('pages.depratments.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'content' => $request->input('content'),
            
        ];


        Depratments::create($data);

        return redirect()->route('depratments.index')->with('success', 'Record created successfully.');
    }


public function show($id)
{
    $item = Depratments::findOrFail($id);
    return view('pages.depratments.show', compact('item'));
}


        public function edit($id)
    {
        $item = Depratments::findOrFail($id);
        return view('pages.depratments.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'content' => $request->input('content'),
            
        ];


        $item = Depratments::findOrFail($id);
        $item->update($data);

        return redirect()->route('depratments.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Depratments::findOrFail($id);
        $item->delete();


        return redirect()->route('depratments.index')->with('success', 'Record deleted successfully.');
    }
}
