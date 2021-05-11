<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soal;
use App\Tanya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TanyaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
            'pilihan4' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->jawaban == "pilihan1") {
            $jawaban_benar = $request->pilihan1;
        } elseif ($request->jawaban == "pilihan2") {
            $jawaban_benar = $request->pilihan2;
        } elseif ($request->jawaban == "pilihan3") {
            $jawaban_benar = $request->pilihan3;
        } elseif ($request->jawaban == "pilihan4") {
            $jawaban_benar = $request->pilihan4;
        } else {
            $jawaban_benar = NULL;
        }

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            $tanya = Tanya::create([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $jawaban_benar,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'pilihan4' => $request->pilihan4,
                'pilihan_benar' => $request->jawaban,
                'gambar' => $gambar
            ]);
        } else {
            $gambar = NULL;
            $tanya = Tanya::create([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $jawaban_benar,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'pilihan4' => $request->pilihan4,
                'pilihan_benar' => $request->jawaban,
                'gambar' => $gambar
            ]);
        }

        if (!$tanya) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
            'pilihan4' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->jawaban == "pilihan1") {
            $jawaban_benar = $request->pilihan1;
        } elseif ($request->jawaban == "pilihan2") {
            $jawaban_benar = $request->pilihan2;
        } elseif ($request->jawaban == "pilihan3") {
            $jawaban_benar = $request->pilihan3;
        } elseif ($request->jawaban == "pilihan4") {
            $jawaban_benar = $request->pilihan4;
        } else {
            $jawaban_benar = NULL;
        }

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
                'jawaban' => $jawaban_benar,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'pilihan4' => $request->pilihan4,
                'pilihan_benar' => $request->jawaban,
                'gambar' => $gambar
            ]);

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
            }
        } else {
            $tanya = Tanya::find($id);
            $tanya->update([
                'id_soal' => $request->id_soal,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $jawaban_benar,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'pilihan4' => $request->pilihan4,
                'pilihan_benar' => $request->jawaban,
            ]);

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
            }
        }
    }

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
            return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('soal.show', Crypt::encrypt($request->id_soal)));
        }
    }
}
