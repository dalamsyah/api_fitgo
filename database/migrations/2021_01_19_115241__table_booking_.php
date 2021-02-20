<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("order_id", 100);
            $table->integer("team_id");
            $table->string("kode_lapangan", 30);
            $table->string("kode_sublapangan", 30);
            $table->string("jam", 30);
            $table->string("tanggal", 20);
            $table->integer("harga");
            $table->string("tipe_pembayaran", 10);
            $table->integer("pay");
            $table->integer("dp");
            $table->string("email", 100);
            $table->string("status", 30);
            $table->timestamps();

            // $table->unsignedInteger('kode_lapangan');


            // $table->primary(['kode_lapangan', 'kode_sublapangan', 'tanggal', 'jam']);


            // $table->unique(array( 'kode_sublapangan', 'tanggal', 'jam', 'status'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
