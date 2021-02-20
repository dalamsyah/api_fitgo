<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
 
    protected $fillable = [
        'nama_team', 'image_url', 'email', 'deleted'
    ];
 
}