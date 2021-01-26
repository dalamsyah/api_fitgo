<?php

namespace App\Http\Controllers;

use App\Lapangan;
use Illuminate\Http\Request;

class MasterController extends Controller
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

    public function getMaster(Request $request){

        if($request->input("q") == "lapangan"){

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "lapangans" => Lapangan::all(),
                ]
            ];


            return response()->json($out, 200);

        }else{

           $out = [
                "message" => "not found master",
                "results"  => null
            ]; 

            return response()->json($out, 200);
        }

        

    }

    //
}
