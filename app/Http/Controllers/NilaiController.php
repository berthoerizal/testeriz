<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Tanya;
use App\Daftar;
use App\jawab;
use App\Nilai;
use App\User;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nilai_peserta($id)
    {

        $soal = Soal::find($id);

        $title = "Nilai";

        $nilais = DB::table('nilais')
            ->leftJoin('users', 'nilais.id_user', '=', 'users.id')
            ->leftJoin('soals', 'nilais.id_soal', '=', 'soals.id')
            ->select('nilais.*', 'users.name as nama_peserta', 'soals.judul_soal')
            ->where('nilais.id_soal', $id)
            ->get();

        if ($soal->id_user == Auth::user()->id) {
            return view('nilai.index', ['title' => $title, 'soal' => $soal, 'nilais' => $nilais]);
        } else {
            return abort(404);
        }
    }

    public function detail_nilai($id_soal, $id_user)
    {
        $title = "Info Nilai";
        $jawabs = DB::table('jawabs')
            ->join('tanyas', 'jawabs.id_tanya', '=', 'tanyas.id')
            ->select('jawabs.*', 'tanyas.pertanyaan', 'tanyas.gambar')
            ->where('jawabs.id_soal', $id_soal)
            ->where('jawabs.id_user', $id_user)
            ->get();

        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.id', $id_soal)
            ->first();

        $user = User::find($id_user);

        $nilai = DB::table('nilais')
            ->leftJoin('users', 'nilais.id_user', '=', 'users.id')
            ->leftJoin('soals', 'nilais.id_soal', '=', 'soals.id')
            ->select('nilais.*', 'users.name as nama_peserta', 'soals.judul_soal')
            ->where('nilais.id_soal', $id_soal)
            ->where('nilais.id_user', $id_user)
            ->first();

        if ($user->id == Auth::user()->id || Auth::user()->id_role == 21) {
            return view('nilai.show', ['title' => $title, 'jawabs' => $jawabs, 'soal' => $soal, 'nilai' => $nilai, 'user' => $user]);
        } else {
            return abort(404);
        }
    }

    public function status_nilai($id)
    {
        $soal = Soal::find($id);
        if ($soal->status_nilai == 'draft') {
            $soal->update([
                'status_nilai' => 'publish'
            ]);
        } else {
            $soal->update([
                'status_nilai' => 'draft'
            ]);
        }

        $soal = Soal::find($id);
        if ($soal->status_nilai == 'draft') {
            session()->flash('success', 'Nilai tidak bisa dilihat oleh peserta.');
            return redirect(route('nilai_peserta', $id));
        } else {
            session()->flash('success', 'Nilai bisa dilihat oleh peserta.');
            return redirect(route('nilai_peserta', $id));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
