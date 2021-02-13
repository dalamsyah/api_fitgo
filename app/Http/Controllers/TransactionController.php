<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

use DB;

class TransactionController extends Controller
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

    public function getUpdateOrder(Request $request){
        $data = Booking::where("order_id", $request->input('order_id'))
                        ->where("status", "SUCCESS")->get();

        $out = [
                "message" => "get update order",
                "results"  => [
                    "ordersTemp" => $data,
                ]
            ];


        return response()->json($out, 200);

    }

    public function save(Request $request){

        $orders = json_decode($request->getContent(), true);
        $callback = array();

        $date = new \DateTime();

        for($i = 0; $i < count($orders); $i++){
            $order = $orders[$i];

            $data = [
                "order_id" => $order['order_id'],
                "kode_lapangan" => $order['kode_lapangan'],
                "kode_sublapangan" => $order['kode_sublapangan'],
                "jam" => $order['jam'],
                "tanggal" => $order['tanggal'],
                "harga" => $order['price'],
                "tipe_pembayaran" => $order['tipe_pembayaran'],
                "pay" => $order['pay'],
                "dp" => $order['dp'],
                "email" => $order['email'],
                "status" => $order['status'],
                "created_at" => $date,
                "updated_at" => $date,
            ];

            $pending = DB::table('bookings')
              ->where('kode_lapangan', $data['kode_lapangan'] )
              ->where('kode_sublapangan', $data['kode_sublapangan'] )
              ->where('jam', $data['jam'] )
              ->where('tanggal', $data['tanggal'] )
              ->where('status', '=', 'PENDING')
              ->first();

            if($pending !== null){

                $out = [
                    "code" => 200,
                    "message" => "Maaf, Transaksi ini sedang diproses, Mohon tunggu atau pilih transaksi yang lain! ",
                    "results"  => null
                ];

                return response()->json($out, $out["code"]);

            }

            $success = DB::table('bookings')
              ->where('kode_lapangan', $data['kode_lapangan'] )
              ->where('kode_sublapangan', $data['kode_sublapangan'] )
              ->where('jam', $data['jam'] )
              ->where('tanggal', $data['tanggal'] )
              ->where('status', '=', 'SUCCESS')
              ->first();

            if($success !== null){

                $out = [
                    "code" => 200,
                    "message" => "Maaf, Transaksi ini sudah ada yg booking! ",
                    "results"  => null
                ];

                return response()->json($out, $out["code"]);

            }

            array_push($callback, $data);

        }

        Booking::insert($callback);
        
        $out = [
                "code" => 201,
                "message" => "post transaction succesfuly",
                "results"  => null
            ];

        return response()->json($out, 200);
    }

    public function postUpdateOrder(Request $request){

        $row = DB::table('bookings')
              ->where('pay', $request->input('nominal') )
              ->update(['status' => 'SUCCESS']);

        $data = Booking::where("pay", $request->input('nominal'))->get();

        $out = [
            "message" => "update transaction succesfuly ",
            "results"  => [
                "ordersTemp" => $data,
            ]
        ];

        return response()->json($out, 200);

    }

    public function postUpdateOrderFailed(Request $request){

        $row = DB::table('bookings')
              ->where('order_id', $request->input('order_id') )
              ->update(['status' => 'FAILED']);

        $data = Booking::where("order_id", $request->input('order_id'))->get();

        $out = [
            "message" => "update transaction succesfuly ",
            "results"  => [
                "ordersTemp" => $data,
            ]
        ];

        return response()->json($out, 200);

    }

    public function postUpdateOrderWithStatus(Request $request){

        $row = DB::table('bookings')
              ->where('order_id', $request->input('order_id') )
              ->update(['status' => $request->input('status')] );

        $data = Booking::where("order_id", $request->input('order_id'))->get();

        $out = [
            "message" => "update transaction succesfuly ",
            "results"  => [
                "ordersTemp" => $data,
            ]
        ];

        return response()->json($out, 200);

    }

    //
}
