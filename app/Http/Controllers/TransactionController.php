<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

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
                "jam" => $order['jam'],
                "tanggal" => $order['tanggal'],
                "harga" => $order['harga'],
                "tipe_pembayaran" => $order['tipe_pembayaran'],
                "pay" => $order['pay'],
                "email" => $order['order_id'],
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

    public function save2(Request $request){

        $data = [
            "email" => $request->input("email"),
            "booking" => $request->input("booking"),
            "tipe_pembayaran" => $request->input("tipe_pembayaran"),
            "nominal" => $request->input("nominal"),
            "status" => $request->input("status")
        ];

        if (Booking::create($data)) {
            $out = [
                "message" => "save transaction success",
                "results"  => [
                    "bookings" => $data,
                ]
            ];


            return response()->json($out, 200);
        }else{

            $out = [
                "message" => "save transaction failed",
                "results"  => [
                    "bookings" => null,
                ]
            ];

            return response()->json($out, 500);
        }

    
    }

    //
}
