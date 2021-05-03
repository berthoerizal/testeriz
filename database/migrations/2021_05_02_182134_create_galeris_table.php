<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalerisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // protected $fillable = ['judul_gambar', 'jenis_gambar', 'gambar'];
        Schema::create('galeris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_jenis_gambar')->nullable();
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('galeris');
    }
}
