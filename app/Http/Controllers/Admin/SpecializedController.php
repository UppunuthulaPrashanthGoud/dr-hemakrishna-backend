<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialized;

class SpecializedController extends Controller
{

        public function index()
    {
        $items = Specialized::all();
        return view('pages.specialized.index', compact('items'));
    }


        public function create()
    {
        return view('pages.specialized.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'title' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            
        ];


        Specialized::create($data);

        return redirect()->route('specialized.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Specialized::findOrFail($id);
        return view('pages.specialized.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
            'title' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            
        ];


        $item = Specialized::findOrFail($id);
        $item->update($data);

        return redirect()->route('specialized.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Specialized::findOrFail($id);
        $item->delete();


        return redirect()->route('specialized.index')->with('success', 'Record deleted successfully.');
    }
}
