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
                <div class="float-left">
                    <a href="{{ route('soal.show', $soal->id) }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('soal.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_soal">Judul Soal</label>
                                    <input type="text" class="form-control" name="judul_soal" id="judul_soal"
                                        placeholder="Judul Soal" value="{{ $soal->judul_soal }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_soal">Jenis Soal</label>
                                    <select class="form-control" id="jenis_soal" name="jenis_soal">
                                        <option value="objektif" @if ($soal->jenis_soal == 'objektif') selected @endif>Objektif</option>
                                        <option value="essay" @if ($soal->jenis_soal == 'essay') selected @endif>Essay</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status_soal">Status Soal</label>
                                    <select class="form-control" id="status_soal" name="status_soal">
                                        <option value="publish" @if ($soal->status_soal == 'publish') selected @endif>Publish</option>
                                        <option value="draft" @if ($soal->status_soal == 'draft') selected @endif>Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_galeri">Tampilan Soal Objektif</label>
                                    <select class="form-control" id="select2" name="id_galeri">
                                        @foreach ($galeri as $galeri)
                                            <option value="{{ $galeri->id_jenisgaleris }}" @if ($soal->id_galeri == $galeri->id_jenisgaleris) selected @endif>
                                                {{ $galeri->nama_jenisgaleris }} ({{ $galeri->jumlah_gambar }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="materi_file">Materi File</label><br />
                                    <input type="file" id="materi_file" name="materi_file">
                                    <p><i>Kosongkan jika tidak/sudah memiliki materi file.</i></p>
                                </div>
                                <div>
                                    <label for="materi_video">Link Video</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon3">https://www.youtube.com/watch?v=</span>
                                        </div>
                                        <input type="text" name="materi_video" id="materi_video"
                                            value="{{ $soal->materi_video }}" placeholder="Kode Video Youtube"
                                            class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                        <p><i>Kosongkan jika tida memiliki materi video.</i></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal_mulai"
                                                value="{{ $soal->tanggal_mulai }}" id="tanggal_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_mulai">Waktu Mulai</label>
                                            <input type="time" class="form-control form-control-sm" name="waktu_mulai"
                                                value="{{ $soal->waktu_mulai }}" id="waktu_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal_selesai"
                                                value="{{ $soal->tanggal_selesai }}" id="tanggal_selesai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_selesai">Waktu Selesai</label>
                                            <input type="time" class="form-control form-control-sm" name="waktu_selesai"
                                                value="{{ $soal->waktu_selesai }}" id="waktu_selesai">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

@endsection