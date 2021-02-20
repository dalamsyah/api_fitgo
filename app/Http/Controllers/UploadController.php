<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Log;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function upload(Request $request){

        $file = $request->file('image');

        $file->move("images",$file->getClientOriginalName());

        Log::debug($file);

        $out = [
            "code" => 200,
            "message" => "Upload photo",
            "results"  => null
        ];
        return response()->json($out, $out["code"]);
    }

    //
}
