<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableLapangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("kode_lapangan", 30);
            $table->string("kode_sublapangan", 30);
            $table->string("nama_lapangan", 30);
            $table->string("nama_tempat", 30);
            $table->string("tipe", 30);
            $table->string("keterangan", 100);
            $table->string("gambar", 30);
            $table->string("lokasi", 100);
            $table->double("latitude");
            $table->double("longitude");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lapangans');
    }
}
