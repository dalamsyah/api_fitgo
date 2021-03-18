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
    			"email" => "dimasalamsyah0712@gmail.com",
    			"username" => "admin",
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