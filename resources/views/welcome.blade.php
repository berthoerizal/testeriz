@extends('layouts_ujian.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body" style="padding: 30px;">
                <!-- desktop -->
                <div class="d-md-block d-none">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex h-100">
                                <div class="justify-content-center align-self-center">
                                    <h2>
                                        <strong>{{ $konfigurasi->namaweb }}</strong><br />
                                        Ujian Online
                                    </h2>
                                    <p>{{ $konfigurasi->desc1 }}</p>
                                    <a href="{{ route('soal.index') }}" class="btn btn-outline-info">
                                        Buat Soal
                                    </a>
                                    <a href="{{ route('ujian.index') }}" class="btn btn-outline-info">
                                        Ikuti Ujian
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('assets/images/home.png') }}" width="100%" />
                        </div>
                    </div>
                </div>

                <!-- handphone -->
                <div class="d-sm-block d-md-none">
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <img src="{{ asset('assets/images/home.png') }}" width="100%" />
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex h-100">
                                <div class="justify-content-center align-self-center">
                                    <h2>
                                        <strong>{{ $konfigurasi->namaweb }}</strong><br />
                                        Ujian Online
                                    </h2>
                                    <p>{{ $konfigurasi->desc1 }}</p>
                                    <a href="{{ route('soal.index') }}" class="btn btn-outline-info">
                                        Buat Soal
                                    </a>
                                    <a href="{{ route('ujian.index') }}" class="btn btn-outline-info">
                                        Ikuti Ujian
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
