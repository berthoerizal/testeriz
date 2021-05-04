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
                @include('galeri.modal_update_jenis')
            </div>
            <div class="card-body">
                <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_jenis_gambar">Jenis</label>
                                            <select class="form-control" id="id_jenis_gambar" name="id_jenis_gambar">
                                                @foreach ($jenis as $jenis)
                                                    <option value="{{ $jenis->id }}" @if ($galeri->id_jenis_gambar == $jenis->id) selected @endif>
                                                        {{ $jenis->nama_jenis_gambar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="gambar">Gambar</label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                                        onchange="previewImg()">
                                                    <label class="custom-file-label" for="gambar">Pilih
                                                        Gambar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Preview Image:</p>
                                @if (!$galeri->gambar)
                                    <img src="{{ asset('assets/images/imagedefault.png') }}" alt=""
                                        class="img-thumbnail img-preview">
                                @else
                                    <img src="{{ asset('assets/images/' . $galeri->gambar) }}" alt=""
                                        class="img-thumbnail img-preview">
                                @endif
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
    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const gambarLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabel.textContent = gambar.files[0].name;

            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

    </script>
@endsection
