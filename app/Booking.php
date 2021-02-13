<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
 
    protected $fillable = [
        'order_id', 'kode_lapangan', 'kode_sublapangan', 'jam', 'tanggal', 'harga', 'dp', 'tipe_pembayaran', 'pay', 'email', 'status'
    ];
 
}