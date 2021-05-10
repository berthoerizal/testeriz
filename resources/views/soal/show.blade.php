@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        @if ($soal->id_user == $user->id)
            <h1 class="h3 mb-2 text-gray-800">Info Soal</h1>
        @else
            <h1 class="h3 mb-2 text-gray-800">Info Ujian</h1>
        @endif
        <hr>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card">
                    @if ($soal->materi_video != null)
                        <div class="embed-responsive embed-responsive-1by1 card-img-top">
                            <iframe width="420" height="315" src="https://www.youtube.com/embed/{{ $soal->materi_video }}"
                                frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        <img class="card-img-top" src="{{ asset('assets/images/novideodefault.PNG') }}"
                            alt="Card image cap">
                    @endif
                    <div class="card-body text-center">
                        <p class="card-text"><b>Materi Video</b></p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow col-md-12 mb-3">
                    <div class="card-header">
                        Detail Informasi
                        @if ($soal->id_user == $user->id)
                            Soal
                        @else
                            Ujian
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td><i class="fa fa-user"></i> Dibuat Oleh</td>
                                        <td>{{ $soal->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-book"></i> Materi File</td>
                                        <td>
                                            @if ($soal->materi_file == null)
                                                <i>Tidak ada file.</i>
                                            @else
                                                <a href="{{ route('download_materi', $soal->id) }}"><i
                                                        class="fa fa-download"></i>
                                                    {{ $soal->materi_file }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-star"></i> Judul</td>
                                        <td><b>{{ $soal->judul_soal }}</b></td>
                                    </tr>
                                    @if ($soal->id_user == $user->id)
                                        <tr>
                                            <td><i class="fa fa-newspaper"></i> Status</td>
                                            <td>
                                                @if ($soal->status_soal == 'publish')
                                                    <b style="color: green;"><?php echo
                                                        ucwords($soal->status_soal); ?></b>
                                                @else
                                                    <b style="color: red;"><?php echo
                                                        ucwords($soal->status_soal); ?></b>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td><i class="fa fa-calendar"></i> Jadwal Mulai</td>
                                        <td>
                                            @if ($soal->tanggal_mulai == null || $soal->waktu_mulai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_mulai)) .
                                                '
                                                ' .
                                                $soal->waktu_mulai; ?>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-calendar"></i> Jadwal Selesai</td>
                                        <td>
                                            @if ($soal->tanggal_selesai == null || $soal->waktu_selesai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_selesai)) .
                                                ' ' . $soal->waktu_selesai; ?>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-key"></i> Password
                                            @if ($soal->id_user == $user->id)
                                                Soal
                                            @else
                                                Ujian
                                            @endif
                                        </td>
                                        <td><b>{{ $soal->pass_soal }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-right">
                            @if ($soal->id_user == $user->id)
                                @include('soal.delete')
                                <a class="btn btn-primary btn-sm mt-2"
                                    href="{{ route('soal.edit', Crypt::encrypt($soal->id)) }}">
                                    <i class="fa fa-pencil-alt"></i>
                                    Edit
                                </a>
                                <a href="{{ route('nilai_peserta', $soal->id) }}" class="btn btn-primary btn-sm mt-2"><i
                                        class="fa fa-trophy"></i>
                                    Nilai</a>
                                @include('soal.modal_create_tanya')
                            @else
                                @if ($cek_daftar == 0)
                                    @include('ujian.modal_daftar_ujian')
                                @elseif ($cek_daftar==1)
                                    <a href="{{ route('tunggu_ujian', [$soal->id]) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-arrow-right"></i>
                                        Masuk
                                        Ujian</a>
                                @elseif($cek_daftar==2)
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('detail_nilai', ['id_soal' => $soal->id, 'id_user' => $user->id]) }}">
                                        <i class="fa fa-trophy"></i>
                                        Nilai
                                    </a>
                                @else
                                    <p style="color: red;">Data tidak ditemukan.</p>
                                @endif
                            @endif
                        </span>
                        <br><br>
                    </div>
                </div>
            </div>

            @if ($soal->id_user == $user->id)
                <div class="col-md-12">
                    <div class="card shadow col-md-12 mb-4">
                        <div class="card-header">
                            <div class="float-left">
                                Pertanyaan & Kunci Jawaban Soal
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
                                            <th>Jawaban Benar</th>
                                            <th width="20%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($tanya as $tanya) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i; ?>
                                            </td>
                                            <td class="text-center">
                                                @if (!$tanya->gambar)
                                                    <img src="{{ asset('assets/images/imagedefault.png') }}"
                                                        class="img img-responsive img-thumbnail" width="50px">
                                                @else
                                                    <img src="{{ asset('assets/images/' . $tanya->gambar) }}"
                                                        class="img img-responsive img-thumbnail" width="50px">
                                                @endif
                                            </td>
                                            <td><?php echo $tanya->pertanyaan; ?></td>
                                            <td>{{ $tanya->jawaban }}</td>
                                            <td>
                                                @include('soal.modal_edit_tanya')
                                                @include('soal.modal_delete_tanya')
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
            @endif
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
@endsection
