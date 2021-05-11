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

    public function index()
    {
        $title = "Ikuti Ujian";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('id_user', '!=', Auth::user()->id)
            ->where('status_soal', 'publish')
            ->get();
        return view('ujian.index', ['title' => $title, 'soal' => $soal]);
    }

    public function daftar_ujian(Request $request)
    {
        $request->validate([
            'password_ujian' => 'required',
        ]);

        $soal = Soal::find($request->id_soal);
        if ($soal->pass_soal != $request->password_ujian) {
            session()->flash('error', 'Gagal melakukan pendaftaran, Password Ujian Salah');
            return redirect(route('soal.show', $request->id_soal));
        }

        $daftar = Daftar::create([
            'id_user' => Auth::user()->id,
            'id_soal' => $request->id_soal,
            'status_daftar' => 1
        ]);

        $tanya = DB::table('tanyas')->where('id_soal', $request->id_soal)->get();
        foreach ($tanya as $tanya) {
            $jawab = Jawab::create([
                'id_user' => Auth::user()->id,
                'id_soal' => $request->id_soal,
                'id_tanya' => $tanya->id,
                'jawaban_benar' => $tanya->jawaban,
                'jawaban_user' => NULL,
                'status_jawab' => 0
            ]);
        }

        if (!$daftar) {
            session()->flash('error', 'Gagal melakukan pendaftaran.');
            return redirect(route('soal.show', $request->id_soal));
        } else {
            session()->flash('success', 'Berhasil melakukan pendaftaran.');
            return redirect(route('tunggu_ujian', $request->id_soal));
        }
    }

    public function tunggu_ujian($id)
    {
        $title = "Tunggu Ujian";
        $soal = Soal::find($id);
        $cek_daftar = DB::table('daftars')
            ->where('id_soal', $id)
            ->where('id_user', Auth::user()->id)
            ->first();
        if ($cek_daftar->status_daftar == 1) {
            return view('ujian.tunggu_ujian', ['title' => $title, 'soal' => $soal]);
        } else {
            return abort(404);
        }
    }

    public function jawab_ujian($id)
    {
        $title = "Ujian";
        $soal = Soal::find($id);

        $data = DB::table('tanyas')->where('id_soal', $id)->paginate(1);

        // $tanya = DB::table('tanyas')->where('id_soal', $id)->get();

        $jawab = DB::table('jawabs')
            ->where('id_soal', $id)
            ->where('id_user', Auth::user()->id)
            ->paginate(1);

        $cek_daftar = DB::table('daftars')
            ->where('id_soal', $id)
            ->where('id_user', Auth::user()->id)
            ->first();

        if ($cek_daftar->status_daftar == 1) {
            return view('ujian.jawab_ujian', ['data' => $data, 'soal' => $soal, 'title' => $title, 'jawab' => $jawab]);
        } else {
            return abort(404);
        }
        // return view('ujian.jawab_ujian', compact('data'));
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

        $update_jawabs = DB::table('jawabs')
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
