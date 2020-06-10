<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function TestMethod(){
        return response()->json([
            'mgs' =>'This is test json data'
        ]);
    }
}
