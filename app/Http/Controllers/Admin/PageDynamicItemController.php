<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageDynamicItem;
use Illuminate\Http\Request;
use DataTables;

class PageDynamicItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Page $page)
    {
        if ($request->ajax()) {
            $data = $page->dynamicItems;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('pages.dynamic-items.edit', ['page' => $row->page_id, 'dynamic_page_item' => $row->id]);
                    $deleteUrl = route('pages.dynamic-items.destroy', ['page' => $row->page_id, 'dynamic_page_item' => $row->id]);

                    $btn = '<a href="' . $editUrl . '" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.dynamic-items.index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function create(Page $page)
    {
        return view('pages.dynamic-items.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page->dynamicItems()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('pages.dynamic-items.index', $page->id)
            ->with('success', 'Item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @param  \App\Models\PageDynamicItem  $dynamic_page_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page, PageDynamicItem $dynamic_page_item)
    {
        return view('pages.dynamic-items.edit', compact('page', 'dynamic_page_item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @param  \App\Models\PageDynamicItem  $dynamic_page_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page, PageDynamicItem $dynamic_page_item)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $dynamic_page_item->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('pages.dynamic-items.index', $page->id)
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @param  \App\Models\PageDynamicItem  $dynamic_page_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page, PageDynamicItem $dynamic_page_item)
    {
        $dynamic_page_item->delete();

        return response()->json(['success' => 'Item deleted successfully.']);
    }
}