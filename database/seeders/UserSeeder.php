<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$users = [
    		[
                "email" => "dimasalamsyah07@gmail.com",
                "username" => "super",
                "password" => Hash::make("123456"),
                "token" => "",
                "type" => 3,
                "verifikasi" => "true"
            ],
            [
    			"email" => "dimasalamsyah0712@gmail.com",
    			"username" => "java",
    			"password" => Hash::make("123456"),
    			"token" => "",
                "type" => 2,
                "verifikasi" => "true"
    		],
            [
                "email" => "samsungaxa12@gmail.com",
                "username" => "sis",
                "password" => Hash::make("123456"),
                "token" => "",
                "type" => 2,
                "verifikasi" => "true"
            ],
    		[
    			"email" => "dani@gmail.com",
    			"username" => "dani",
    			"password" => Hash::make("123456"),
    			"token" => "",
                "type" => 1,
                "verifikasi" => "true"
    		],
    		[
    			"email" => "apit@gmail.com",
    			"username" => "apit",
    			"password" => Hash::make("123456"),
    			"token" => "",
                "type" => 1,
                "verifikasi" => "true"
    		]
    	];

    	DB::table('users')->insert(
            $users
        );
    }

}