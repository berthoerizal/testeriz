<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Konfigurasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        $title = "Dashboard";
        $user_count = User::all()->count();
        $soal_count = DB::table('soals')->where('id_user', Auth::user()->id)->count();
        $ujian_count = DB::table('daftars')->where('id_user', Auth::user()->id)->count();
        $konfig = Konfigurasi::first();
        $ujians = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('id_user', '!=', Auth::user()->id)
            ->where('status_soal', 'publish')
            ->take(3)
            ->get();
        return view('dashboard', ['title' => $title, 'user_count' => $user_count, 'soal_count' => $soal_count, 'ujian_count' => $ujian_count, 'konfig' => $konfig, 'ujians' => $ujians]);
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
