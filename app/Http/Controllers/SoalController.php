<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Soal;
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
        $title = "Buat Soal";
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
        $galeri = DB::table('galeris')
            ->leftJoin('jenisgaleris', 'galeris.id_jenis_gambar', '=', 'jenisgaleris.id')
            ->select('jenisgaleris.id as id_jenisgaleris', 'jenisgaleris.nama_jenis_gambar as nama_jenisgaleris', DB::raw('count(galeris.id) as jumlah_gambar'))
            ->groupBy('galeris.id_jenis_gambar')
            ->get();
        return view('soal.create', ['title' => $title, 'galeri' => $galeri]);
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
                'id_galeri' => $request->id_galeri,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'jenis_soal' => $request->jenis_soal,
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
                'id_galeri' => $request->id_galeri,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'jenis_soal' => $request->jenis_soal,
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
        $title = "Detail Soal";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenisgaleris', 'soals.id_galeri', '=', 'jenisgaleris.id')
            ->select('soals.*', 'users.name', 'jenisgaleris.nama_jenis_gambar')
            ->where('soals.id', $id)
            ->first();
        return view('soal.show', ['title' => $title, 'soal' => $soal]);
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
        $galeri = DB::table('galeris')
            ->leftJoin('jenisgaleris', 'galeris.id_jenis_gambar', '=', 'jenisgaleris.id')
            ->select('jenisgaleris.id as id_jenisgaleris', 'jenisgaleris.nama_jenis_gambar as nama_jenisgaleris', DB::raw('count(galeris.id) as jumlah_gambar'))
            ->groupBy('galeris.id_jenis_gambar')
            ->get();
        return view('soal.edit', ['title' => $title, 'galeri' => $galeri, 'soal' => $soal]);
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
                'id_galeri' => $request->id_galeri,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'jenis_soal' => $request->jenis_soal,
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
                'id_galeri' => $request->id_galeri,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'jenis_soal' => $request->jenis_soal,
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
