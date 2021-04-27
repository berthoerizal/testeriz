<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $title = "Users";
        $users = User::all();
        return view('user.index', ['title' => $title, 'users' => $users]);
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
        if ($request->password == $request->confirm_password) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]);

            $users = User::all();
            foreach ($users as $users) {
                if ($users->email == $request->email) {
                    session()->flash('error', 'Data gagal ditambah, email ' . $request->email . ' sudah digunakan');
                    return redirect(route('user.index'));
                }
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
            ]);

            if (!$user) {
                session()->flash('error', 'Data gagal ditambah');
                return redirect(route('user.index'));
            } else {
                session()->flash('success', 'Data berhasil ditambah');
                return redirect(route('user.index'));
            }
        } else {
            session()->flash('error', 'Konfirmasi Password tidak valid');
            return redirect(route('user.index'));
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
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role
        ]);

        if (!$user) {
            session()->flash('error', 'Data gagal diubah');
            return redirect(route('user.index'));
        } else {
            session()->flash('success', 'Data berhasil diubah');
            return redirect(route('user.index'));
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
        $user = User::find($id);
        if ($id == Auth::user()->id) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('user.index'));
        } else {
            $old_image = public_path() .  '/assets/images/' . $user->gambar;
            @unlink($old_image);
            $user->delete();
            if (!$user) {
                session()->flash('error', 'Data gagal dihapus');
                return redirect(route('user.index'));
            } else {
                session()->flash('success', 'Data berhasil dihapus');
                return redirect(route('user.index'));
            }
        }
    }

    public function reset_password($id)
    {
        if ($id == Auth::user()->id) {
            session()->flash('error', 'Password gagal diubah');
            return redirect(route('user.index'));
        } else {
            $karakter = "ABCDEFGHIJKLMNOPQRSTUVWQYZ1234567890";
            $password = substr(str_shuffle($karakter), 0, 8);
            $user = User::find($id);
            $user->update([
                'password' => Hash::make($password)
            ]);

            $user = User::find($id);
            session()->flash('success', 'Email: ' . $user->email . ' | Password Baru: ' . $password . '');
            return redirect(route('user.index'));
        }
    }
}
