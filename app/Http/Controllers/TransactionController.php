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
                    "orders" => $data,
                ]
            ];


        return response()->json($out, 200);

    }

    public function save(Request $request){

        $orders = json_decode($request->getContent(), true);
        $callback = array();

        for($i = 0; $i < count($orders); $i++){
            $order = $orders[$i];

            $data = [
                "order_id" => $order['order_id'],
                "kode_lapangan" => $order['kode_lapangan'],
                "kode_sublapangan" => $order['kode_sublapangan'],
                "jam" => $order['jam'],
                "tanggal" => $order['tanggal'],
                "harga" => $order['harga'],
                "tipe_pembayaran" => $order['tipe_pembayaran'],
                "pay" => $order['pay'],
                "email" => $order['email'],
                "status" => $order['status']
            ];

            Booking::create($data);

            array_push($callback, $data);

        }
        

        $out = [
                "message" => "post transaction ",
                "results"  => [
                    "orders" => $callback,
                ]
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
                "orders" => $data,
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
                "orders" => $data,
            ]
        ];

        return response()->json($out, 200);

    }

    //
}
