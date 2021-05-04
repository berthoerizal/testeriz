@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="float-right">
                    <a href="{{ route('soal.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                        style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Judul Soal</th>
                                <th>Jenis Soal</th>
                                <th>Status Soal</th>
                                <th>Jadwal Soal</th>
                                <th>Password Soal</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($soal as $soal) { ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td><?php echo $soal->judul_soal; ?><br /><span>Oleh:
                                        {{ $soal->name }}</span></td>
                                <td><b><?php echo $soal->jenis_soal; ?></b></td>
                                <td>
                                    @if ($soal->status_soal == 'publish')
                                        <b style="color: green;"><?php echo $soal->status_soal; ?></b>
                                    @else
                                        <b style="color: red;"><?php echo $soal->status_soal; ?></b>
                                    @endif
                                </td>
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
                                <td><b>{{ $soal->pass_soal }}</b></td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm" href="{{ route('soal.show', $soal->id) }}">
                                        <i class="fa fa-book"></i>
                                        Detail
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
