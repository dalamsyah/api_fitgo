<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

use App\User;

use PDF;
use DB;

use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\Mail;

class VerifikasiController extends Controller
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

    public function verifikasi(Request $request){

        $decrypted = base64_decode($request->input("q"));

        $cek = User::where("username", $decrypted)
            ->where("verifikasi", "false")
            ->update(['verifikasi' => 'true']);

        if($cek == 0){
            $out = [
                "code" => 200,
                "message" => "not found data",
                "varifikasi" => $cek
            ];

            return response()->json($out, $out['code']);
        }

        $out = [
            "code" => 201,
            "message" => "update verifikasi succesfuly",
            "varifikasi" => $cek
        ];

        return response()->json($out, $out['code']);

    }

    //
}
