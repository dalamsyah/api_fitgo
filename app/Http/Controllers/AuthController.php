<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
 
        $username = $request->input("username");
        $password = $request->input("password");
 
        $user = User::where("username", $username)->first();
 
        if (!$user) {
            $out = [
                "message" => "login_failed",
                "results"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, 500);
        }
 
        if (Hash::check($password, $user->password)) {
            $newtoken  = $this->generateRandomString();
 
            $user->update([
                'token' => $newtoken
            ]);
 
            $out = [
                "message" => "login_success",
                "results"  => [
                    "user" => $user
                ]
            ];


            return response()->json($out, 200);
        } else {
            $out = [
                "message" => "login_failed",
                "results"  => [
                    "token" => null,
                ]
            ];

            return response()->json($out, 200);
        }
 
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6'
        ]);
 
        $username = $request->input("username");
        $email = $request->input("email");
        $password = $request->input("password");
 
        $hashPwd = Hash::make($password);
 
        $data = [
            "username" => $username,
            "email" => $email,
            "password" => $hashPwd
        ];
 
 
 
        if (User::create($data)) {
            $out = [
                "message" => "register_success",
                "code"    => 201,
            ];
        } else {
            $out = [
                "message" => "vailed_regiser",
                "code"   => 404,
            ];
        }
 
        return response()->json($out, $out['code']);
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
        $karakkter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakkter);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $karakkter[rand(0, $panjang_karakter - 1)];
        }
        return $str;
    }

    //
}
