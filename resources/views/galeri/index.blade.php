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
                    <a href="{{ route('galeri.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%" class="text-center">Gambar</th>
                                <th>Nama File</th>
                                <th>Jenis</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($galeris as $galeri) { ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    @if (!$galeri->gambar)
                                        <img src="{{ asset('assets/images/imagedefault.png') }}"
                                            class="img img-responsive img-thumbnail" width="50px">
                                    @else
                                        @include('galeri.modal_image')
                                    @endif
                                </td>
                                <td><?php echo $galeri->gambar; ?></td>
                                <td><b>{{ $galeri->nama_jenis_gambar }}</b></td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm" href="{{ route('galeri.edit', $galeri->id) }}"><i
                                            class="fa fa-pencil-alt"></i> Edit</a>
                                    @include('galeri.delete')
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
