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
    		],
    		[
    			"email" => "dani@gmail.com",
    			"username" => "dani",
    			"password" => Hash::make("123456"),
    			"token" => "",
    		],
    		[
    			"email" => "apit@gmail.com",
    			"username" => "apit",
    			"password" => Hash::make("123456"),
    			"token" => "",
    		]
    	];

    	DB::table('users')->insert(
            $users
        );
    }

}