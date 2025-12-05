<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imagegallery;

class ImagegalleryController extends Controller
{

        public function index()
    {
        $items = Imagegallery::all();
        return view('pages.imagegallery.index', compact('items'));
    }


        public function create()
    {
        return view('pages.imagegallery.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            
        ];


        Imagegallery::create($data);

        return redirect()->route('imagegallery.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Imagegallery::findOrFail($id);
        return view('pages.imagegallery.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
            
        ]);

        $data = [
            'image' => $request->input('image'),
            
        ];


        $item = Imagegallery::findOrFail($id);
        $item->update($data);

        return redirect()->route('imagegallery.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Imagegallery::findOrFail($id);
        $item->delete();


        return redirect()->route('imagegallery.index')->with('success', 'Record deleted successfully.');
    }
}
