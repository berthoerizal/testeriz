<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Daftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SoalController extends Controller
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
        $title = "Soal";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('id_user', Auth::user()->id)
            ->get();
        return view('soal.index', ['title' => $title, 'soal' => $soal]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Soal";
        return view('soal.create', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_soal' => 'required'
        ]);

        if ($request->hasFile('materi_file')) {
            $resorce  = $request->file('materi_file');
            $materi_file   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/materi', $materi_file);

            $soal = Soal::create([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'status_soal' => $request->status_soal,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);
        } else {
            $materi_file = NULL;
            $soal = Soal::create([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'status_soal' => $request->status_soal,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);
        }


        if (!$soal) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('soal.index'));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('soal.show', $soal->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Info Soal";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.id', $id)
            ->first();

        $tanya = DB::table('tanyas')
            ->select('tanyas.*')
            ->where('id_soal', $id)
            ->get();

        $daftar = DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $id)
            ->first();

        if (!$daftar) {
            $cek_daftar = 0;
        } else {
            if ($daftar->status_daftar == 1) {
                $cek_daftar = 1;
            } else {
                $cek_daftar = 2;
            }
        }

        return view('soal.show', ['title' => $title, 'soal' => $soal, 'tanya' => $tanya, 'cek_daftar' => $cek_daftar]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Soal";
        $soal = Soal::find($id);
        return view('soal.edit', ['title' => $title, 'soal' => $soal]);
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
        $request->validate([
            'judul_soal' => 'required'
        ]);

        if ($request->hasFile('materi_file')) {
            $resorce  = $request->file('materi_file');
            $materi_file   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/materi', $materi_file);

            $soal = Soal::find($id);
            $old_image = public_path() . "/assets/materi/" . $soal->materi_file;
            @unlink($old_image);

            $soal->update([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'status_soal' => $request->status_soal,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);

            if (!$soal) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.edit', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $id));
            }
        } else {
            $soal = Soal::find($id);
            $soal->update([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'status_soal' => $request->status_soal,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);

            if (!$soal) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.edit', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $id));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $soal = Soal::find($id);
        $old_image = public_path() . "/assets/materi/" . $soal->materi_file;
        @unlink($old_image);
        $soal->delete();

        DB::table('tanyas')->where('id_soal', $id)->delete();
        DB::table('daftars')->where('id_soal', $id)->delete();
        DB::table('jawabs')->where('id_soal', $id)->delete();

        if (!$soal) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('soal.index'));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('soal.index'));
        }
    }

    public function download_materi($id)
    {
        $soal = Soal::find($id);
        return response()->download((public_path() . "/assets/materi/" . $soal->materi_file));
    }
}
