<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

use PDF;
use DB;

use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
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

    public function sendemail(){
        Mail::to("dimasalamsyah0712@gmail.com")->send(new BookedEmail());
 
        return "Email telah dikirim";
    }

    public function sendverifikasi(){

        $data = [
            "username" => "dimas",
            "link" => "1234sffss"
        ];

        Mail::to("dimasalamsyah0712@gmail.com")->send(new VerifikasiEmail($data));
 
        return "Email verifikasi telah dikirim";
    }

    public function view(){
        return view('verifikasi_link');
    }

    //
}
