<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Highlights;

class HighlightsController extends Controller
{

        public function index()
    {
        $items = Highlights::all();
        return view('pages.highlights.index', compact('items'));
    }


        public function create()
    {
        return view('pages.highlights.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'countnumber' => 'required',
            'image' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'title' => $request->input('title'),
            'countnumber' => $request->input('countnumber'),
            'image' => $request->input('image'),
            'content' => $request->input('content'),
            
        ];


        Highlights::create($data);

        return redirect()->route('highlights.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Highlights::findOrFail($id);
        return view('pages.highlights.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'countnumber' => 'required',
            'image' => 'required',
            'content' => 'required',
            
        ]);

        $data = [
            'title' => $request->input('title'),
            'countnumber' => $request->input('countnumber'),
            'image' => $request->input('image'),
            'content' => $request->input('content'),
            
        ];


        $item = Highlights::findOrFail($id);
        $item->update($data);

        return redirect()->route('highlights.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Highlights::findOrFail($id);
        $item->delete();


        return redirect()->route('highlights.index')->with('success', 'Record deleted successfully.');
    }
}
