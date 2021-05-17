<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Tanya;
use App\Daftar;
use App\jawab;
use App\User;
use Illuminate\Support\Facades\Crypt;

class UjianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ujian_sudah_daftar()
    {
        $title = "Ikuti Ujian - Sudah Daftar";

        //sudah daftar
        $soal = DB::table('daftars')
            ->join('soals', 'daftars.id_soal', '=', 'soals.id')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'daftars.status_daftar', 'users.name')
            ->where('daftars.id_user', '=', Auth::user()->id)
            ->orderBy('soals.id', 'desc')
            ->get();

        return view('ujian.ujian_sudah_daftar', ['title' => $title, 'soal' => $soal]);
    }

    public function semua_ujian()
    {
        $title = "Ikuti Ujian - Semua Ujian";


        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.id_user', '!=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->orderBy('soals.id', 'desc')
            ->get();

        return view('ujian.semua_ujian', ['title' => $title, 'soal' => $soal]);
    }

    public function daftar_ujian(Request $request)
    {
        $request->validate([
            'password_ujian' => 'required',
        ]);

        $soal = Soal::find($request->id_soal);
        if ($soal->pass_soal != $request->password_ujian) {
            session()->flash('error', 'Gagal melakukan pendaftaran, Password Ujian Salah');
            return redirect(route('soal.show', $soal->slug_soal));
        }

        $tanya = DB::table('tanyas')->where('id_soal', $request->id_soal)->get();
        foreach ($tanya as $tanya) {
            $create_jawab = Jawab::create([
                'id_user' => Auth::user()->id,
                'id_soal' => $request->id_soal,
                'id_tanya' => $tanya->id,
                'jawaban_benar' => $tanya->jawaban,
                'jawaban_user' => NULL,
                'status_jawab' => NULL
            ]);
        }

        $daftar = Daftar::create([
            'id_user' => Auth::user()->id,
            'id_soal' => $request->id_soal,
            'status_daftar' => 1
        ]);

        if (!$daftar) {
            session()->flash('error', 'Gagal melakukan pendaftaran.');
            return redirect(route('soal.show', $soal->slug_soal));
        } else {
            session()->flash('success', 'Berhasil melakukan pendaftaran.');
            return redirect(route('tunggu_ujian', $soal->slug_soal));
        }
    }

    public function tunggu_ujian($slug_soal)
    {
        $title = "Tunggu Ujian";
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();
        $cek_daftar = DB::table('daftars')
            ->where('id_soal', $soal->id)
            ->where('id_user', Auth::user()->id)
            ->first();
        if ($cek_daftar->status_daftar == 1) {
            return view('ujian.tunggu_ujian', ['title' => $title, 'soal' => $soal]);
        } else {
            return abort(404);
        }
    }

    public function jawab_ujian($slug_soal)
    {
        $title = "Ujian";
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();
        $data = DB::table('tanyas')->where('id_soal', $soal->id)->paginate(1);

        $jawab = DB::table('jawabs')
            ->where('id_soal', $soal->id)
            ->where('id_user', Auth::user()->id)
            ->paginate(1);

        $cek_daftar = DB::table('daftars')
            ->where('id_soal', $soal->id)
            ->where('id_user', Auth::user()->id)
            ->first();

        if ($cek_daftar->status_daftar == 1) {
            return view('ujian.jawab_ujian', ['data' => $data, 'soal' => $soal, 'title' => $title, 'jawab' => $jawab]);
        } else {
            return abort(404);
        }
    }

    public function user_jawab_ujian(Request $request, $id_soal, $id_tanya)
    {
        $tanya = DB::table('tanyas')
            ->where('id', $id_tanya)
            ->where('id_soal', $id_soal)
            ->first();

        if ($request->jawaban_user == $tanya->jawaban) {
            $status_jawab = 1;
            // 1 bernilai benar
        } else {
            $status_jawab = 0;
            // 0 bernilai salah
        }
        $update_jawab = DB::table('jawabs')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $id_soal)
            ->where('id_tanya', $id_tanya)
            ->update(array('jawaban_user' => $request->jawaban_user, 'status_jawab' => $status_jawab));

        return redirect()->back();
    }

    public function selesai_ujian($id_soal)
    {
        $update_daftars = DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $id_soal)
            ->update(array('status_daftar' => 2));

        $user = User::find(Auth::user()->id);

        return redirect(route('detail_nilai', ['id_soal' => $id_soal, 'id_user' => Crypt::encrypt($user->id)]));
    }
}
