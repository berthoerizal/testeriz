@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
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
                        Detail Informasi Soal
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>Dibuat Oleh</td>
                                        <td>{{ $soal->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Materi File</td>
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
                                        <td>Judul Soal</td>
                                        <td><b>{{ $soal->judul_soal }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tampilan Soal</td>
                                        <td>{{ $soal->nama_jenis_gambar }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Soal</td>
                                        <td>
                                            @if ($soal->status_soal == 'publish')
                                                <b style="color: green;"><?php echo $soal->status_soal; ?></b>
                                            @else
                                                <b style="color: red;"><?php echo $soal->status_soal; ?></b>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jadwal Mulai</td>
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
                                        <td>Jadwal Selesai</td>
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
                                        <td>Password Soal</td>
                                        <td><b>{{ $soal->pass_soal }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-right">
                            @include('soal.delete')
                            <a class="btn btn-primary btn-sm" href="{{ route('soal.edit', $soal->id) }}">
                                <i class="fa fa-pencil-alt"></i>
                                Edit
                            </a>
                            @include('soal.modal_create_tanya')
                        </span>
                        <br><br>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow col-md-12 mb-4">
                    <div class="card-header">
                        <div class="float-left">
                            Pertanyaan Soal
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
                                        <th>Jawaban</th>
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
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');
            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

    </script>
@endsection
