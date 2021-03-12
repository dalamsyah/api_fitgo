<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
 
    protected $fillable = [
        'owner_email', 'kode_lapangan', 'kode_sublapangan', 'nama_lapangan', 'nama_tempat', 'tipe', 'keterangan', 'gambar', 'lokasi', 'longitude', 'latitude' 
    ];
 
}