@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow col-md-12 mb-4">
                    <div class="card-header">
                        <div class="float-left">
                            <a href="{{ route('soal.index') }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-arrow-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="text-align: center;">
                            @if ($soal->materi_video != null)
                                <div class="embed-responsive embed-responsive-1by1">
                                    <iframe width="420" height="315"
                                        src="https://www.youtube.com/embed/{{ $soal->materi_video }}" frameborder="0"
                                        allowfullscreen></iframe>
                                </div>
                            @else
                                <img src="{{ asset('assets/images/novideodefault.PNG') }}"
                                    class="img img-responsive img-preview" width="200px">
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        Materi Video
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow col-md-12 mb-4">
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
                                        <td>Jenis Soal</td>
                                        <td>
                                            @if ($soal->jenis_soal == 'objektif')
                                                <b>Objektif</b><br>
                                                Tampilan: {{ $soal->nama_jenis_gambar }}
                                            @else
                                                <b>Essay</b>
                                            @endif
                                        </td>
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
                                        <td>Jadwal Soal</td>
                                        <td>
                                            @if ($soal->tanggal_mulai == null || $soal->tanggal_selesai == null || $soal->waktu_mulai == null || $soal->waktu_selesai == null)
                                                Mulai: -<br />
                                                Selesai: -
                                            @else
                                                <?php echo 'Mulai: ' .
                                                date('d-m-Y', strtotime($soal->tanggal_mulai)) .
                                                '
                                                ' .
                                                $soal->waktu_mulai .
                                                '<br />' .
                                                'Selesai: ' .
                                                date('d-m-Y', strtotime($soal->tanggal_selesai)) .
                                                ' ' .
                                                $soal->waktu_selesai; ?>
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
                        </span>
                        <br><br>
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
