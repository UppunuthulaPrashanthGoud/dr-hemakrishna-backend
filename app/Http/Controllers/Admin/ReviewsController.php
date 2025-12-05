<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewsController extends Controller
{

        public function index()
    {
        $items = Reviews::all();
        return view('pages.reviews.index', compact('items'));
    }


        public function create()
    {
        return view('pages.reviews.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rating' => 'required',
            'content' => 'required',
            'image' => 'required',
            
        ]);

        $data = [
            'name' => $request->input('name'),
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
            'image' => $request->input('image'),
            
        ];


        Reviews::create($data);

        return redirect()->route('reviews.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Reviews::findOrFail($id);
        return view('pages.reviews.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'rating' => 'required',
            'content' => 'required',
            'image' => 'required',
            
        ]);

        $data = [
            'name' => $request->input('name'),
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
            'image' => $request->input('image'),
            
        ];


        $item = Reviews::findOrFail($id);
        $item->update($data);

        return redirect()->route('reviews.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Reviews::findOrFail($id);
        $item->delete();


        return redirect()->route('reviews.index')->with('success', 'Record deleted successfully.');
    }
}
