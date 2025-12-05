<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\CPU\ImageManager;
use App\Models\Banner;
use File;
use Validator;
use DB;

class BannersController extends Controller
{
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $banners = banner::orderBy('order_position', 'ASC')->get();
        return view('pages.banners.index', compact('banners'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function store(Request $request)
{
    $rules=[];

    if (!$request->has('item_id')) {
        $rules['image'] = 'required';
    }

    // Validate request data
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 401);
    }

    $data = [
        'link' => $request->link ? $request->link : '#',
        'title_en' => $request->title_en,
        'title_ar' => $request->title_ar,
        'image' => $request->image
    ];


    // Check if item_id is present for update
    if ($request->item_id) {
        $banner = Banner::find($request->item_id);

        if (!$banner) {
            return response()->json(['success' => false, 'message' => 'Banner not found.'], 404);
        }

        $banner->update($data);

        return response()->json(['success' => true, 'message' => 'Banner has been updated successfully.']);
    }

    $position = DB::table('banners')->orderBy('id', 'DESC')->first();
    $newposition = $position ? $position->order_position + 1 : 1;

    $data['order_position'] = $newposition;

    Banner::create($data);

    return response()->json(['success' => true, 'message' => 'New banner has been saved successfully.']);
}





    public function edit($id)
    {
        $product = Banner::find($id);
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
       
        $result = DB::table('banners')->where('id', $id)->delete();
        if ($result) {
            return response()->json(['success' => 'Item has been deleted']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function bannerStatus($status, $id){
        $updated_status=0;
        if($status=='on'){
            $updated_status=1;
        }
        $result = DB::table('banners')->where('id', $id)->update(['active'=>$updated_status]);
        if ($result) {
            return response()->json(['success' => 'Status has been updated']);
        } else {
            return response()->json(['success' => 'already updated']);
        }
    }
}
