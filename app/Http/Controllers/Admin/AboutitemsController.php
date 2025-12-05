<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aboutitems;

class AboutitemsController extends Controller
{

        public function index()
    {
        $items = Aboutitems::all();
        return view('pages.aboutitems.index', compact('items'));
    }


        public function create()
    {
        return view('pages.aboutitems.create');
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


        Aboutitems::create($data);

        return redirect()->route('aboutitems.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Aboutitems::findOrFail($id);
        return view('pages.aboutitems.edit', compact('item'));
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


        $item = Aboutitems::findOrFail($id);
        $item->update($data);

        return redirect()->route('aboutitems.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Aboutitems::findOrFail($id);
        $item->delete();


        return redirect()->route('aboutitems.index')->with('success', 'Record deleted successfully.');
    }
}
