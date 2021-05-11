@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include('partial.message')
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $soal->judul_soal }}</h1>
        <hr>

        @if ($soal->status_nilai == 'draft')
            <div class="alert alert-secondary" role="alert">
                Nilai belum di-<b>Publish</b> oleh <b>{{ $soal->name }}</b>.
            </div>
        @else
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        @if ($user->gambar != null)
                            <img class="card-img-top" src="{{ asset('assets/images/' . $user->gambar) }}"
                                alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('assets/images/profiledefault.PNG') }}"
                                alt="Card image cap">
                        @endif
                        <div class="card-body text-center">
                            <p class="card-text"><b>{{ $user->name }}</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card shadow col-md-12 mb-4">
                        <div class="card-header">
                            <div class="float-right">
                                Informasi Nilai Pengguna
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td><i class="fa fa-user"></i> Dijawab Oleh</td>
                                            <td>{{ $nilai->nama_peserta }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-star"></i> Judul</td>
                                            <td><b>{{ $nilai->judul_soal }}</b></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-question"></i> Jumlah Pertanyaan</td>
                                            <td>{{ $jumlah_pertanyaan }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-check"></i> Jumlah Terjawab</td>
                                            <td>{{ $nilai->terjawab }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-trophy"></i> Nilai</td>
                                            <td><?php echo number_format($nilai->total_nilai); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow col-md-12 mb-3">
                        <div class="card-header">
                            <div class="float-left">
                                Kunci Jawaban
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%" class="text-center">Gambar</th>
                                            <th>Pertanyaan</th>
                                            <th>Jawaban Pengguna</th>
                                            <th>Jawaban Benar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($jawabs as $jawab) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i; ?>
                                            </td>
                                            <td class="text-center">
                                                @if (!$jawab->gambar)
                                                    <img src="{{ asset('assets/images/imagedefault.png') }}"
                                                        class="img img-responsive img-thumbnail" width="50px">
                                                @else
                                                    <img src="{{ asset('assets/images/' . $jawab->gambar) }}"
                                                        class="img img-responsive img-thumbnail" width="50px">
                                                @endif
                                            </td>
                                            <td><?php echo $jawab->pertanyaan; ?></td>
                                            @if ($jawab->jawaban_user == $jawab->jawaban_benar)
                                                <td style="background-color: #6AFB71; color:#333;">
                                                    {{ $jawab->jawaban_user }}
                                                </td>
                                            @else
                                                <td style="background-color: #E88880; color:#333;">
                                                    {{ $jawab->jawaban_user }}
                                                </td>
                                            @endif
                                            <td style="background-color: #6AFB71; color:#333;">
                                                {{ $jawab->jawaban_benar }}
                                            </td>
                                        </tr>
                                        <?php $i++;}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

@endsection
