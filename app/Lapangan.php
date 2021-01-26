<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
 
    protected $fillable = [
        'kode_lapangan', 'nama_lapangan', 'nama_tempat', 'keterangan', 'gambar', 'lokasi', 'longitude', 'latitude' 
    ];
 
}