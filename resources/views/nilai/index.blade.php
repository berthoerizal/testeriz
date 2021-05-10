@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }} - {{ $soal->judul_soal }}</h1>
        <hr>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="float-left">
                    @if ($soal->status_nilai == 'publish')
                        <a href="{{ route('status_nilai', $soal->id) }}" class="btn btn-dark btn-sm"><i
                                class="fa fa-bell-slash"></i> <b>Draft</b></a>
                        <a href="" class="btn btn-success btn-sm disabled"><i class="fa fa-bell"></i> <b>Publish</b></a>
                    @else
                        <a href="" class="btn btn-dark btn-sm disabled"><i class="fa fa-bell-slash"></i> <b>Draft</b></a>
                        <a href="{{ route('status_nilai', $soal->id) }}" class="btn btn-success btn-sm"><i
                                class="fa fa-bell"></i> <b>Publish</b></a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Peserta</th>
                                <th>Terjawab</th>
                                <th>Jumlah Pertanyaan</th>
                                <th>Nilai</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($nilais as $nilai) { ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td><?php echo $nilai->nama_peserta; ?></td>
                                <td class="text-center"><?php echo $nilai->jawaban_benar; ?>
                                </td>
                                <td class="text-center"><?php echo $nilai->jumlah_pertanyaan; ?></td>
                                <td class="text-right"><?php echo number_format($nilai->total_nilai); ?></td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('detail_nilai', ['id_soal' => $nilai->id_soal, 'id_user' => $nilai->id_user]) }}">
                                        <i class="fa fa-book"></i>
                                        Info
                                    </a>
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
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
@endsection
