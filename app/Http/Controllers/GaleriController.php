<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Galeri;
use App\Jenisgaleri;

class GaleriController extends Controller
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
        $title = "Galeri";
        $galeris = DB::table('galeris')
            ->leftJoin('jenisgaleris', 'galeris.id_jenis_gambar', '=', 'jenisgaleris.id')
            ->select('galeris.*', 'jenisgaleris.nama_jenis_gambar')
            ->get();
        return view('galeri.index', ['title' => $title, 'galeris' => $galeris]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Gambar";
        $jenis = DB::table('jenisgaleris')
            ->select('*')
            ->get();
        return view('galeri.create', ['title' => $title, 'jenis' => $jenis]);
    }

    public function store_jenis(Request $request)
    {
        $jenis = Jenisgaleri::create([
            'nama_jenis_gambar' => $request->nama_jenis_gambar
        ]);

        if (!$jenis) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('galeri.create'));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('galeri.create'));
        }
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
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $x = 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            foreach ($image as $files) {
                $file_name = time() . "_" . $files->getClientOriginalName();
                $files->move(public_path() . '/assets/images', $file_name);
                $data[] = $file_name;

                $file = new Galeri;
                $file->gambar = $data[$x];
                $file->id_jenis_gambar = $request->id_jenis_gambar;
                $file->save();

                $x++;
            }
        }


        session()->flash('success', 'Data berhasil ditambah');
        return redirect(route('galeri.index'));
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
        $title = "Tambah Gambar";
        $jenis = DB::table('jenisgaleris')
            ->select('*')
            ->get();
        $galeri = Galeri::find($id);
        return view('galeri.edit', ['title' => $title, 'jenis' => $jenis, 'galeri' => $galeri]);
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
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   = $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            $galeri = Galeri::find($id);
            if ($galeri->gambar != 'imagedefault.png') {
                $old_image = public_path() . "/assets/images/" . $galeri->gambar;
                @unlink($old_image);
            }

            $galeri->update([
                'gambar' => $gambar,
                'id_jenis_gambar' => $request->id_jenis_gambar,
            ]);

            if (!$galeri) {
                $galeri = Galeri::find($id);
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('galeri.edit', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('galeri.index'));
            }
        } else {
            $galeri = Galeri::find($id);
            $galeri->update([
                'id_jenis_gambar' => $request->id_jenis_gambar
            ]);

            if (!$galeri) {
                $galeri = Galeri::find($id);
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('galeri.edit', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('galeri.index'));
            }
        }
    }

    public function update_jenis(Request $request, $id)
    {
        $jenis = Jenisgaleri::create([
            'nama_jenis_gambar' => $request->nama_jenis_gambar
        ]);

        if (!$jenis) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('galeri.edit', $id));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('galeri.edit', $id));
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
        $galeri = Galeri::find($id);
        if ($galeri->gambar != 'imagedefault.png') {
            $old_image = public_path() . "/assets/images/" . $galeri->gambar;
            @unlink($old_image);
        }
        $galeri->delete();

        if (!$galeri) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('galeri.index'));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('galeri.index'));
        }
    }
}
