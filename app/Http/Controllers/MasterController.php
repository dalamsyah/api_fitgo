<?php

namespace App\Http\Controllers;

use App\Lapangan;
use App\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;

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

    public function getNotifcation(Request $request){

        $orders = DB::table('bookings')
                                        ->distinct()
                                        ->join('lapangans', function ($join) {
                                            $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                            $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                        })
                                        ->join('teams', function ($join) {
                                            $join->on('bookings.team_id', '=', 'teams.id');
                                        })
                                        ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                        ->where('bookings.status', '=', 'SUCCESS' )
                                        ->where('lapangans.owner_email', '=', $request->input("owner_email") )
                                        ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                        ->get();

        $id = count($orders);
        $team = "";
        $jam = "";
        $nama_lapangan = "";

        if(count($orders) > 0){
            $arr = $id - 1;
            $id = $orders[$arr]->id;
            $team = $orders[$arr]->nama_team;
            $nama_lapangan = $orders[$arr]->nama_lapangan;
            $jam = $orders[$arr]->jam;
        }

        $out = [
            "message" => "get notification",
            "results"  => [
                "notifications" => [
                    "id" => $id,
                    "title" => "BOOKING",
                    "desc" => $team." ".$jam." ".$nama_lapangan,
                    "orders" => $orders,
                ]
            ]
        ]; 

        return response()->json($out, 200);
    }

    public function tes(){

        $arr = array();

        $endDay = Carbon::now()->getPreciseTimestamp(3);

        for($i = 1; $i < 30; $i++){
            $ar = [
                'kode_lapangan' => 'SIS',
                'kode_sublapangan' => $endDay,
                'jam' => '0'.$i.':00',
                'price' => 100000,
                'valid' => '2021-03-01',
            ];

            array_push($arr, $ar);
        }

        return $arr;// response()->json($t, 200);
    }

    public function getInvoice(Request $request){

        $out = [
            "message" => "get ".$request->input("q")." success",
            "results"  => [
                "invoices" => DB::table('bookings')
                            ->distinct()
                            ->join('lapangans', function ($join) {
                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                            })
                            ->join('teams', function ($join) {
                                $join->on('bookings.team_id', '=', 'teams.id');
                            })
                            ->select('bookings.*','lapangans.nama_lapangan', 'teams.nama_team',
                                    DB::raw('(bookings.dp / bookings.harga) as dpText')
                                )
                            ->where('bookings.status', '=', 'SUCCESS' )
                            ->where('lapangans.owner_email', '=', $request->input("user_email") )
                            ->where('bookings.id', '>', 0 )
                            ->get()
            ]
        ];


        return response()->json($out, 200);
    }

    public function getInvoiceDetail(Request $request, $orderId){
        
        $out = [
            "message" => "get ".$request->input("q")." success",
            "results"  => [
                "invoice" => DB::table('bookings')
                            ->distinct()
                            ->join('lapangans', function ($join) {
                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                            })
                            ->join('teams', function ($join) {
                                $join->on('bookings.team_id', '=', 'teams.id');
                            })
                            ->select('bookings.*','lapangans.nama_lapangan', 'teams.nama_team',
                                    DB::raw('(bookings.dp / bookings.harga) as dpText')
                                )
                            ->where('bookings.status', '=', 'SUCCESS' )
                            ->where('lapangans.owner_email', '=', $request->input("user_email") )
                            ->where('bookings.id', '>', 0 )
                            ->where('bookings.order_id', '=', $orderId )
                            ->first()
            ]
        ];


        return response()->json($out, 200);
    }

    public function getMaster(Request $request){

        if($request->input("q") == "invoice"){

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "invoices" => DB::table('bookings')
                                ->distinct()
                                ->join('lapangans', function ($join) {
                                    $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                    $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                })
                                ->join('teams', function ($join) {
                                    $join->on('bookings.team_id', '=', 'teams.id');
                                })
                                ->select('bookings.*','lapangans.nama_lapangan', 'teams.nama_team',
                                        DB::raw('(bookings.dp / bookings.harga) as dpText')
                                    )
                                ->where('bookings.status', '=', 'SUCCESS' )
                                ->where('lapangans.owner_email', '=', $request->input("user_email") )
                                ->where('bookings.id', '>', 0 )
                                ->get()
                ]
            ];


            return response()->json($out, 200);

        }else if($request->input("q") == "job_notification"){

            $mytime = Carbon::now();
            $date = $mytime->toDateTimeString();

            /*
            * 1 -> user
            * 2 -> admin
            */
            if($request->input("user_type") == 3 ){

                $out = [
                    "message" => "get ".$request->input("q")." success",
                    "results"  => [
                        "notifications" => DB::table('bookings')
                                            ->distinct()
                                            ->join('lapangans', function ($join) {
                                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                            })
                                            ->join('teams', function ($join) {
                                                $join->on('bookings.team_id', '=', 'teams.id');
                                            })
                                            ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                            ->where('bookings.status', '=', 'SUCCESS' )
                                            // ->where('bookings.created_at', '>', $request->input("created_at") ) //utk job
                                            // ->where('lapangans.owner_email', '=', $request->input("user_email") )
                                            ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                            ->get()
                    ]
                ];

            } else if($request->input("user_type") == 2 ){

                $out = [
                    "message" => "get ".$request->input("q")." success",
                    "results"  => [
                        "notifications" => DB::table('bookings')
                                            ->distinct()
                                            ->join('lapangans', function ($join) {
                                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                            })
                                            ->join('teams', function ($join) {
                                                $join->on('bookings.team_id', '=', 'teams.id');
                                            })
                                            ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                            ->where('bookings.status', '=', 'SUCCESS' )
                                            // ->where('bookings.created_at', '>', $request->input("created_at") ) //utk job
                                            ->where('lapangans.owner_email', '=', $request->input("user_email") )
                                            ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                            ->get()
                    ]
                ];
                
            } else {

                $out = [
                    "timenow" => $date,
                    "message" => "get ".$request->input("q")." success",
                    "results"  => [
                        "notifications" => DB::table('bookings')
                                            ->distinct()
                                            ->join('lapangans', function ($join) {
                                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                            })
                                            ->join('teams', function ($join) {
                                                $join->on('bookings.team_id', '=', 'teams.id');
                                            })
                                            ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                            ->where('bookings.status', '=', 'SUCCESS' )
                                            ->where('bookings.email', '=', $request->input("user_email") )
                                            // ->where('bookings.created_at', '>', $date ) //utk job
                                            ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                            ->get()
                    ]
                ];
            }

            return response()->json($out, 200);

        }else if($request->input("q") == "notification"){

            Log::debug($request);


            /*
            * 1 -> user
            * 2 -> admin
            */
            if($request->input("user_type") > 1 ){

                $out = [
                    "message" => "get ".$request->input("q")." success",
                    "results"  => [
                        "notifications" => DB::table('bookings')
                                            ->distinct()
                                            ->join('lapangans', function ($join) {
                                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                            })
                                            ->join('teams', function ($join) {
                                                $join->on('bookings.team_id', '=', 'teams.id');
                                            })
                                            ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                            ->where('bookings.status', '=', 'SUCCESS' )
                                            ->where('lapangans.owner_email', '=', $request->input("user_email") )
                                            ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                            ->get()
                    ]
                ];
                
            }else{

                $mytime = Carbon::now();
                $date = $mytime->toDateTimeString();

                $out = [
                    "timenow" => $date,
                    "message" => "get ".$request->input("q")." success",
                    "results"  => [
                        "notifications" => DB::table('bookings')
                                            ->distinct()
                                            ->join('lapangans', function ($join) {
                                                $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                                $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                            })
                                            ->join('teams', function ($join) {
                                                $join->on('bookings.team_id', '=', 'teams.id');
                                            })
                                            ->select('bookings.*', 'lapangans.nama_lapangan', 'teams.nama_team')
                                            ->where('bookings.status', '=', 'SUCCESS' )
                                            ->where('bookings.email', '=', $request->input("user_email") )
                                            ->where('bookings.id', '>', $request->input("lastIdNotification") )
                                            ->get()
                    ]
                ];
            }

            return response()->json($out, 200);

        }else if($request->input("q") == "lapangan"){

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "lapangans" => DB::table('lapangans')
                                        ->select('*',
                                            DB::raw(' (SELECT MAX(price) as max_price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan ) as max_price'),

                                            DB::raw(' (SELECT MIN(price) as max_price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan ) as min_price')
                                        )
                                        ->where('lapangans.kode_lapangan', '=', $request->input("kode_lapangan") )
                                        ->get()
                ]
            ];


            return response()->json($out, 200);

        }else if($request->input("q") == "distinctlapangan"){

            $vinyl = "Vinyl";
            $sintetis = "Sintetis";

            //for user only
            if( $request->input("user_type") == 1){

                $distinctlapangans = DB::table('lapangans')
                    ->distinct()
                    ->join('prices', function ($join) {
                        $join->on('prices.kode_lapangan', '=', 'lapangans.kode_lapangan');
                    })
                    ->select('lapangans.kode_lapangan', 'lapangans.nama_tempat', 'lapangans.lokasi', DB::raw('(SELECT gambar as gambar FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan limit 1) as gambar '), DB::raw('(SELECT COUNT(*) as vinyl FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$vinyl.'" ) as vinyl '), DB::raw('(SELECT COUNT(*) as sintetis FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$sintetis.'" ) as sintetis ')  )
                    ->groupBy('lapangans.kode_lapangan', 'lapangans.nama_tempat','lapangans.lokasi')
                    ->get();

            //for admin only
            }else if( $request->input("user_type") == 2 ){

                $distinctlapangans = DB::table('lapangans')
                    ->distinct()
                    ->join('prices', function ($join) {
                        $join->on('prices.kode_lapangan', '=', 'lapangans.kode_lapangan');
                    })
                    ->select('lapangans.kode_lapangan', 'lapangans.nama_tempat', 'lapangans.lokasi', DB::raw('(SELECT gambar as gambar FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan limit 1) as gambar '), DB::raw('(SELECT COUNT(*) as vinyl FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$vinyl.'" ) as vinyl '), DB::raw('(SELECT COUNT(*) as sintetis FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$sintetis.'" ) as sintetis ')  )
                    ->where('lapangans.owner_email', '=', $request->input("user_email"))
                    ->groupBy('lapangans.kode_lapangan', 'lapangans.nama_tempat','lapangans.lokasi')
                    ->get();

            //other case
            }else{
                $distinctlapangans = DB::table('lapangans')
                    ->distinct()
                    ->join('prices', function ($join) {
                        $join->on('prices.kode_lapangan', '=', 'lapangans.kode_lapangan');
                    })
                    ->select('lapangans.kode_lapangan', 'lapangans.nama_tempat', 'lapangans.lokasi', DB::raw('(SELECT gambar as gambar FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan limit 1) as gambar '), DB::raw('(SELECT COUNT(*) as vinyl FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$vinyl.'" ) as vinyl '), DB::raw('(SELECT COUNT(*) as sintetis FROM lapangans lap where lap.kode_lapangan = lapangans.kode_lapangan and lap.tipe = "'.$sintetis.'" ) as sintetis ')  )
                    ->groupBy('lapangans.kode_lapangan', 'lapangans.nama_tempat','lapangans.lokasi')
                    ->get();
            }

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "distinctlapangans" => $distinctlapangans,
                "lapangans" => DB::table('lapangans')
                                        ->select('*',
                                            DB::raw(' (SELECT MAX(price) as max_price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan ) as max_price'),

                                            DB::raw(' (SELECT MIN(price) as max_price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan ) as min_price')
                                        )
                                        ->get()
                ]
            ];


            return response()->json($out, 200);

        }else if($request->input("q") == "orders"){

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

            $valid = date('Y-m-d');
            $tgl = $request->input("tgl");

            $jam1 = "'01:00'";
            $jam2 = "'02:00'";
            $jam3 = "'03:00'";
            $jam4 = "'04:00'";
            $jam5 = "'05:00'";
            $jam6 = "'06:00'";
            $jam7 = "'07:00'";
            $jam8 = "'08:00'";
            $jam9 = "'09:00'";
            $jam10 = "'10:00'";
            $jam11 = "'11:00'";
            $jam12 = "'12:00'";
            $jam13 = "'13:00'";
            $jam14 = "'14:00'";
            $jam15 = "'15:00'";
            $jam16 = "'16:00'";
            $jam17 = "'17:00'";
            $jam18 = "'18:00'";
            $jam19 = "'19:00'";
            $jam20 = "'20:00'";
            $jam21 = "'21:00'";
            $jam22 = "'22:00'";
            $jam23 = "'23:00'";
            $jam24 = "'24:00'";

            $out = [
                "message" => "get ".$request->input("q")." success",
                "results"  => [
                    "lapangans_with_price" => DB::table('lapangans')
                                        ->select('*', 

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam1 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam1"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam2 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam2"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam3 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam3"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam4 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam4"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam5 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam5"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam6 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam6"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam7 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam7"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam8 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam8"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam9 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam9"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam10 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam10"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam11 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam11"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam12 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam12"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam13 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam13"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam14 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam14"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam15 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam15"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam16 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam16"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam17 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam17"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam18 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam18"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam19 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam19"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam20 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam20"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam21 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam21"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam22 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam22"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam23 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam23"),

                                            DB::raw("(SELECT IF(true IS NULL, 'false', 'true') FROM bookings where bookings.kode_lapangan = lapangans.kode_lapangan and bookings.kode_sublapangan = lapangans.kode_sublapangan and bookings.jam = $jam24 and bookings.tanggal = '$tgl' and bookings.status = 'SUCCESS' ) as jam24"),

                                            
                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam1.' ) as priceJam1'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam2.' ) as priceJam2'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam3.' ) as priceJam3'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam4.' ) as priceJam4'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam5.' ) as priceJam5'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam6.' ) as priceJam6'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam7.' ) as priceJam7'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam8.' ) as priceJam8'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam9.' ) as priceJam9'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam10.' ) as priceJam10'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam11.' ) as priceJam11'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam12.' ) as priceJam12'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam13.' ) as priceJam13'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam14.' ) as priceJam14'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam15.' ) as priceJam15'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam16.' ) as priceJam16'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam17.' ) as priceJam17'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam18.' ) as priceJam18'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam19.' ) as priceJam19'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam20.' ) as priceJam20'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam21.' ) as priceJam21'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam22.' ) as priceJam22'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam23.' ) as priceJam23'),

                                            DB::raw(' (SELECT price FROM prices WHERE kode_lapangan = lapangans.kode_lapangan AND kode_sublapangan = lapangans.kode_sublapangan AND jam = '.$jam24.' ) as priceJam24')

                                        )
                                        ->where('lapangans.kode_lapangan', '=', $request->input("kode_lapangan") )
                                        ->get()
                    // "lapangans" => DB::table('lapangans')
                    //                     ->select('*')
                    //                     ->where('lapangans.kode_lapangan', '=', $request->input("kode_lapangan") )
                    //                     ->get()
                    // "prices" => DB::table('prices')
                    //             ->whereDate('valid', '>', $valid)
                    //             ->where('kode_lapangan', $request->input("kode_lapangan"))
                    //             ->get()
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
