<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableUser extends Migration
{
    /**
     * Run the migrations.
     * php artisan make:migration create_pages_table — create=pages
     * php artisan make:migration tabel_mahasiswa --create=mahasiswa
     * php artisan make:migration ini_table_post --create=posts
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("email", 100);
            $table->string("username", 100);
            $table->string("password");
            $table->string("token")->nullable();
            $table->string("verifikasi", 10)->default('false');
            $table->integer("type")->default(1);
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
        Schema::dropIfExists('users');
    }
}
