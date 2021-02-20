<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Booking;

use DB;

use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
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

    public function index()
    {
        $data = User::OrderBy("id", "ASC")->get();
 
        $out = [
            "message" => "data users",
            "results" => $data
        ];
 
        return response()->json($out, 200);
    }

    public function login(Request $request)
    {
        // $this->validate($request, [
        //     'username' => 'required',
        //     'password' => 'required|min:6'
        // ]);
 
        $username = $request->input("username");
        $password = $request->input("password");
 
        $user = User::where("username", $username)->first();
 
        if (!$user) {
            $out = [
                "message" => "data not found",
                "results"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, 200);
        }
 
        if (Hash::check($password, $user->password)) {
            $newtoken  = $this->generateRandomString();
 
            $user->update([
                'token' => $newtoken
            ]);
 
            $out = [
                "message" => "login_success",
                "results"  => [
                    "user" => $user,
                    "orders" => DB::table('bookings')
                                ->join('lapangans', function ($join) {
                                    $join->on('bookings.kode_lapangan', '=', 'lapangans.kode_lapangan');
                                    $join->on('bookings.kode_sublapangan', '=', 'lapangans.kode_sublapangan');
                                })
                                ->join('teams', function ($join) {
                                    $join->on('bookings.team_id', '=', 'teams.id');
                                })
                                ->select('bookings.*', 'teams.nama_team',
                                         DB::raw('CONCAT(lapangans.nama_lapangan,", ",lapangans.nama_tempat) as nama_lapangan'), 
                                         DB::raw('CONCAT(lapangans.nama_tempat," ",lapangans.lokasi) as alamat') )
                                ->where('bookings.email', $user->email)
                                ->get(),
                    "teams" => DB::table('teams')
                                ->where('deleted', 'false')
                                ->where('email', $user->email)
                                ->get(),
                ]
            ];


            return response()->json($out, 200);
        } else {
            $out = [
                "message" => "Kombinasi Username dan Password salah!",
                "results"  => [
                    "token" => null,
                ]
            ];

            return response()->json($out, 200);
        }
 
    }

    public function register(Request $request)
    {
 
        $username = $request->input("username");
        $email = $request->input("email");
        $password = $request->input("password");
 
        $hashPwd = Hash::make($password);
        $hashUsername = Hash::make($username);
 
        $data = [
            "username" => $username,
            "email" => $email,
            "password" => $hashPwd
        ];

        if($username == "" && $email == "" && $password == ""){
            $out = [
                "code" => 200,
                "message" => "Data tidak komplit!",
                "results"  => null
            ];
            return response()->json($out, $out["code"]);
        }
 
        $code = 404;

        $user = User::where("username", $username)->first();

        if ($user) {
            $out = [
                "code" => 200,
                "message" => "Username sudah dipakai!",
                "results"  => null
            ];
            return response()->json($out, $out["code"]);
        }

        $user2 = User::where("email", $email)->first();
 
        if ($user2) {
            $out = [
                "code" => 200,
                "message" => "Email sudah dipakai!",
                "results"  => null
            ];
            return response()->json($out, $out["code"]);
        }
 
        if (User::create($data)) {

            $crypted = base64_encode($username);

            $data['link'] = $crypted;
            $email = Mail::to($email)->send(new VerifikasiEmail($data));

            $out = [
                "code" => 201,
                "message" => "Register succesfuly!",
                "email" => $email,
                "link" => $crypted,
                "results"  => null
            ];

            return response()->json($out, $out["code"]);

        } else {
            $out = [
                "code" => 200,
                "message" => "Register failed!",
                "results"  => null
            ];
            return response()->json($out, $out["code"]);
        }
 
        return response()->json($out, $code);
    }
 
    public function login2(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
 
        $email = $request->input("email");
        $password = $request->input("password");
 
        $user = User::where("email", $email)->first();
 
        if (!$user) {
            $out = [
                "message" => "login_failed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, $out['code']);
        }
 
        if (Hash::check($password, $user->password)) {
            $newtoken  = $this->generateRandomString();
 
            $user->update([
                'token' => $newtoken
            ]);
 
            $out = [
                "message" => "login_success",
                "code"    => 200,
                "result"  => [
                    "token" => $newtoken,
                ]
            ];
        } else {
            $out = [
                "message" => "login_failed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
        }
 
        return response()->json($out, $out['code']);
    }
 
    function generateRandomString($length = 80)
    {
        $karakkter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $panjang_karakter = strlen($karakkter);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $karakkter[rand(0, $panjang_karakter - 1)];
        }
        return $str;
    }

    //
}
