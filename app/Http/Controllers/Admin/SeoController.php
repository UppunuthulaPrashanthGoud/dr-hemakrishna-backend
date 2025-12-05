<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Seo;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Seo::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-pen"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.seo.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function store(Request $request)
    {

        $rules = [
            'page_name' => 'required|string|max:2048',
            'meta_title' => 'nullable|string|max:2048',
            'meta_description' => 'nullable|string|max:2048',
            'meta_keywords' => 'nullable|string|max:2048',
            'meta_author' => 'nullable|string|max:2048',
            'meta_robots' => 'nullable|string|max:2048',
            'og_title' => 'nullable|string|max:2048',
            'og_description' => 'nullable|string|max:2048',
            'og_image' => 'nullable|string|max:2048',
            'og_url' => 'nullable|max:2048',
            'og_type' => 'nullable|string|max:2048',
            'twitter_title' => 'nullable|string|max:2048',
            'twitter_description' => 'nullable|string|max:2048',
            'twitter_image' => 'nullable|string|max:2048',
            'twitter_card' => 'nullable|string|max:2048',
            'canonical' => 'nullable|max:2048',
            'og_local' => 'nullable|string|max:2048',
        ];
        $request->validate($rules);


        $data=[
            'slug' => Str::slug($request->page_name),
            'page_name' => $request->page_name,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'meta_author' => $request->meta_author,
            'meta_robots' => $request->meta_robots,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $request->og_image,
            'og_url' => $request->og_url,
            'og_type' => $request->og_type,
            'twitter_title' => $request->twitter_title,
            'twitter_description' => $request->twitter_description,
            'twitter_image' => $request->twitter_image,
            'twitter_card' => $request->twitter_card,
            'canonical' => $request->canonical,
            'og_local' => $request->og_local,
        ];

        if ($request->item_id) {
            Seo::where(['id' => $request->item_id])->update($data);
            return response()->json(['success' => 'Record has been updated successfully.']);
        } else {
            Seo::create($data);
            return response()->json(['success' => 'New record has been saved successfully.']);
        }
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Seo::find($id);
        return response()->json($product);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Seo::where('id', $id)->delete();

        return response()->json(['success' => 'record has been deleted successfully.']);
    }
}

