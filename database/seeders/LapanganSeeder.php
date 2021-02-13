<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $lapangans = [
            [
                'kode_lapangan' => 'SIS',
                'kode_sublapangan' => 'SIS1',
                'nama_lapangan' => 'Lapangan 1',
                'nama_tempat' => 'Sisilia',
                'keterangan' => 'dengan vinyl',
                'gambar' => 'lapangan4.jpg',
                'lokasi' => 'Setu, Bekasi',
                'latitude' => -6.1793747,
                'longitude' => 106.935557,
            ],
            [
                'kode_lapangan' => 'SIS',
                'kode_sublapangan' => 'SIS2',
                'nama_lapangan' => 'Lapangan 2',
                'nama_tempat' => 'Sisilia',
                'keterangan' => 'dengan vinyl',
                'gambar' => 'lapangan4.jpg',
                'lokasi' => 'Setu, Bekasi',
                'latitude' => -6.1793747,
                'longitude' => 106.935557,
            ],            [
                'kode_lapangan' => 'JAV',
                'kode_sublapangan' => 'JAV1',
                'nama_lapangan' => 'Lapangan 1',
                'nama_tempat' => 'Java',
                'keterangan' => 'dengan rumput sintetis',
                'gambar' => 'lapangan1.jpeg',
                'lokasi' => 'Setu, Bekasi',
                'latitude' => -6.1793747,
                'longitude' => 106.935557,
            ],
            [
                'kode_lapangan' => 'JAV',
                'kode_sublapangan' => 'JAV2',
                'nama_lapangan' => 'Lapangan 2',
                'nama_tempat' => 'Java',
                'keterangan' => 'dengan rumput sintetis',
                'gambar' => 'lapangan1.jpeg',
                'lokasi' => 'Setu, Bekasi',
                'latitude' => -6.1793747,
                'longitude' => 106.935557,
            ]
        ];

        DB::table('lapangans')->insert(
            $lapangans
        );
    }
}
