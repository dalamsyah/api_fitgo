<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
 
    protected $fillable = [
        'order_id', 'kode_lapangan', 'jam', 'tanggal', 'harga', 'tipe_pembayaran', 'pay', 'email', 'status'
    ];
 
}