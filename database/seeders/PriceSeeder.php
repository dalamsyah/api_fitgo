<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $prices = array();

        for($i = 1; $i < 24; $i++){

            $jam = '0'.$i.':00';
            $price = 100000;

            if($i > 9){
                $jam = $i.':00';
                $price += 50000;
            }

            $ar = [
                'kode_lapangan' => 'SIS',
                'kode_sublapangan' => 'SIS1',
                'jam' => $jam,
                'price' => $price,
                'valid' => '2021-03-01',
            ];

            array_push($prices, $ar);
        }

        for($i = 1; $i < 24; $i++){

            $jam = '0'.$i.':00';
            $price = 100000;

            if($i > 9){
                $jam = $i.':00';
                $price += 80000;
            }

            $ar = [
                'kode_lapangan' => 'SIS',
                'kode_sublapangan' => 'SIS2',
                'jam' => $jam,
                'price' => $price,
                'valid' => '2021-03-01',
            ];

            array_push($prices, $ar);
        }

        for($i = 1; $i < 24; $i++){

            $jam = '0'.$i.':00';
            $price = 100000;

            if($i > 9){
                $jam = $i.':00';
                $price += 50000;
            }

            $ar = [
                'kode_lapangan' => 'JAV',
                'kode_sublapangan' => 'JAV1',
                'jam' => $jam,
                'price' => $price,
                'valid' => '2021-03-01',
            ];

            array_push($prices, $ar);
        }

        for($i = 1; $i < 24; $i++){

            $jam = '0'.$i.':00';
            $price = 100000;

            if($i > 9){
                $jam = $i.':00';
                $price += 80000;
            }

            $ar = [
                'kode_lapangan' => 'JAV',
                'kode_sublapangan' => 'JAV2',
                'jam' => $jam,
                'price' => $price,
                'valid' => '2021-03-01',
            ];

            array_push($prices, $ar);
        }


        DB::table('prices')->insert(
            $prices
        );
    }
}
