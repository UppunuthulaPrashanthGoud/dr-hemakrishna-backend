<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorsTestController extends Controller
{
    public function testCors()
    {
        return response()->json([
            'message' => 'CORS is working correctly!',
            'timestamp' => now()
        ], 200);
    }
}