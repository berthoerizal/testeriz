<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ['nama_pengguna', 'judul_soal', 'jumlah_pertanyaan', 'jawaban_benar', 'total_nilai', 'email];
        Schema::create('nilais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->integer('id_soal');
            $table->integer('jumlah_pertanyaan');
            $table->integer('jawaban_benar');
            $table->decimal('total_nilai', 8, 2);
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
        Schema::dropIfExists('nilais');
    }
}
