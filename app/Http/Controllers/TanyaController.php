<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soal;
use App\Tanya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TanyaController extends Controller
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
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            $tanya = Tanya::create([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'gambar' => $gambar
            ]);
        } else {
            $gambar = NULL;
            $tanya = Tanya::create([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'gambar' => $gambar
            ]);
        }

        if (!$tanya) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('soal.show', $request->id_soal));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('soal.show', $request->id_soal));
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
        //
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
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            $tanya = Tanya::find($id);
            $old_image = public_path() . "/assets/images/" . $tanya->gambar;
            @unlink($old_image);

            $tanya->update([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'gambar' => $gambar
            ]);

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', $request->id_soal));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $request->id_soal));
            }
        } else {
            $tanya = Tanya::find($id);
            $tanya->update([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
            ]);

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', $request->id_soal));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $request->id_soal));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $tanya = Tanya::find($id);
        if ($tanya->gambar != 'imagedefault.png') {
            $old_image = public_path() . "/assets/images/" . $tanya->gambar;
            @unlink($old_image);
        }
        $tanya->delete();

        if (!$tanya) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('soal.show', $request->id_soal));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('soal.show', $request->id_soal));
        }
    }
}
