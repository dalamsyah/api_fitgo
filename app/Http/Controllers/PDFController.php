<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

use PDF;
use DB;

class PDFController extends Controller
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

    public function view(){
        return view('bookings_pdf');
    }

    public function cetak(Request $request){
        $bookings = Booking::where("order_id", '1613238022186' )->first();

        // var_dump($bookings); exit;

        $pdf = PDF::loadview('bookings_pdf',[ 'bookings' => $bookings ]);
        return $pdf->download('laporan-bookings-pdf.pdf');

        // return $data;
    }

    //
}
