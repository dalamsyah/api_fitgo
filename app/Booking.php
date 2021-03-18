<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	public $timestamps = false;
 
    protected $fillable = [
        'order_id', 'team_id', 'kode_lapangan', 'kode_sublapangan', 'jam', 'tanggal', 'harga', 'dp', 'tipe_pembayaran', 'pay', 'email', 'status', 'created_at', 'updated_at'
    ];
 
}