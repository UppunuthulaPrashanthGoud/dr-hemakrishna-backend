<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Contact;

class ContactController extends Controller
{
    public function submit_request(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|digits:10',
                'message' => 'required',
                'email' => 'required|email',
            ], [
                'phone.digits' => 'The phone number must be exactly 10 digits.',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 422);
            }
    
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ];
            
            Contact::create($data);
    
            return response()->json(['success' => true, 'message' => 'Request has been submitted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while processing the request.'], 500);
        }
    }
}
