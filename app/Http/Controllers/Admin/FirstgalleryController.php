<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Firstgallery;

class FirstgalleryController extends Controller
{

        public function index()
    {
        $items = Firstgallery::all();
        return view('pages.firstgallery.index', compact('items'));
    }


        public function create()
    {
        return view('pages.firstgallery.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            
        ];


        Firstgallery::create($data);

        return redirect()->route('firstgallery.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Firstgallery::findOrFail($id);
        return view('pages.firstgallery.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            
        ];


        $item = Firstgallery::findOrFail($id);
        $item->update($data);

        return redirect()->route('firstgallery.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Firstgallery::findOrFail($id);
        $item->delete();


        return redirect()->route('firstgallery.index')->with('success', 'Record deleted successfully.');
    }
}
