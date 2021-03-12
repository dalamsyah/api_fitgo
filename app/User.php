<?php
namespace App;
 
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
 
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
 
    protected $fillable = [
        'email', 'password', 'username', 'token', 'verifikasi', 'type'
    ];
 
    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];
}