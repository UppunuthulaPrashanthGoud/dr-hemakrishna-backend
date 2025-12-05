<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

        public function index()
    {
        $items = Category::all();
        return view('pages.category.index', compact('items'));
    }


        public function create()
    {
        return view('pages.category.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            
        ]);

        $data = [
            'name' => $request->input('name'),
            
        ];


        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Record created successfully.');
    }


        public function edit($id)
    {
        $item = Category::findOrFail($id);
        return view('pages.category.edit', compact('item'));
    }


        public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            
        ]);

        $data = [
            'name' => $request->input('name'),
            
        ];


        $item = Category::findOrFail($id);
        $item->update($data);

        return redirect()->route('category.index')->with('success', 'Record updated successfully.');
    }


        public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->delete();


        return redirect()->route('category.index')->with('success', 'Record deleted successfully.');
    }
}
