<?php

namespace App\Http\Controllers;

use App\Lapangan;
use App\Booking;
use Illuminate\Http\Request;

use DB;

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

        }else if($request->input("q") == "distinctlapangan"){

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "distinctlapangans" => DB::table('lapangans')
                                        ->distinct()
                                        ->select('kode_lapangan', 'nama_tempat', 'gambar', 'lokasi')
                                        ->get(),
                ]
            ];


            return response()->json($out, 200);

        }else if($request->input("q") == "orders"){

            /*
            DB::table('bookings')
                                        ->join('lapangans', 'bookings.kode_lapangan', '=', 'lapangans.kode_lapangan')
                                        ->select('bookings.*', 'lapangans.nama_lapangan', DB::raw('CONCAT(lapangans.nama_tempat," ", lapangans.lokasi) as alamat') )
                                        ->get(),
            */

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "orders" => DB::table('bookings')
                                        ->join('lapangans', function ($join) {
                                            $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                            $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                        })
                                        ->select('bookings.*', 'lapangans.nama_lapangan', DB::raw('CONCAT(lapangans.nama_tempat," ", lapangans.lokasi) as alamat') )
                                        ->get(),
                ]
            ];


            return response()->json($out, 200);
        }else if($request->input("q") == "available"){
            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "lapangans" => DB::table('lapangans')
                                        ->distinct()
                                        ->select('*')
                                        ->where('kode_lapangan', '=', $request->input("kode_lapangan") )
                                        ->get(),
                    "available" => DB::table('bookings')
                                        ->join('lapangans', 'bookings.kode_lapangan', '=', 'lapangans.kode_lapangan')
                                        ->select('bookings.*', 'lapangans.nama_lapangan', DB::raw('CONCAT(lapangans.nama_tempat," ", lapangans.lokasi) as alamat') )
                                        ->where('bookings.tanggal', '=', $request->input("tgl"))
                                        ->get(),
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
