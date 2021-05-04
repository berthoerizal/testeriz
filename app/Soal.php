<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = ['id_user', 'id_galeri', 'pass_soal', 'judul_soal', 'slug_soal', 'jenis_soal', 'status_soal', 'tanggal_mulai', 'waktu_mulai', 'tanggal_selesai', 'waktu_selesai', 'materi_file', 'materi_video'];
}
