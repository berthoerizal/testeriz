<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = ['id_user', 'id_soal', 'jumlah_pertanyaan', 'jawaban_benar', 'total_nilai'];
}
