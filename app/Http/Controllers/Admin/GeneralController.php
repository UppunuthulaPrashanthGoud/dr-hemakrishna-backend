<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use DataTables;
use App\CPU\ImageManager;
use Validator;
use App\Models\GeneralSetting;
use Log;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        $general=GeneralSetting::first();
        return view('pages.settings.index', compact('general'));
    }

    public function update(Request $request)
    {

        $data = [
            'header_phone' => $request->header_phone,
            'header_email' => $request->header_email,
            'fb_link' => $request->fb_link,
            'insta_link' => $request->insta_link,
            'twitter_link' => $request->twitter_link,
            'pintrest_link' => $request->pintrest_link,
            'youtube_link' => $request->youtube_link,
            'linkdin_link' => $request->linkdin_link,
            'whatsapp_no' => $request->whatsapp_no,
            'footer_email' => $request->footer_email,
            'footer_phone' => $request->footer_phone,
            'footer_copyright' => $request->footer_copyright,
            'website_name' => $request->website_name,
            'footer_logo' => $request->footer_logo,
            'header_logo' => $request->header_logo,
            'favicon' =>    $request->favicon
        ];
            GeneralSetting::where(['id' =>1])->update($data);
            return redirect()->back()->with('success', "Data has been updated");
        }
   



        public function changeStatus($tableName, $id)
        {
            // Retrieve the record
            $record = DB::table($tableName)->where('id', $id)->first();

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            // Toggle the status
            $newStatus = !$record->status;

            // Update the record
            DB::table($tableName)->where('id', $id)->update(['status' => $newStatus]);

            return response()->json(['status' => $newStatus]);
        }
    
    
    

}
