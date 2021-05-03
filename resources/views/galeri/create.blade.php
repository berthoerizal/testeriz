@extends('layouts.app')

@section('content')
    <style>
        .thumb {
            margin: 10px 5px 0 0;
            width: 100px;
        }

        .sketchy {
            display: inline-block;
            border: 3px solid #333333;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3ch;
            background: #ffffff;
            position: relative;

            &::before {
                content: '';
                border: 2px solid #353535;
                display: block;
                width: 100%;
                height: 100%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate3d(-50%, -50%, 0) scale(1.015) rotate(0.5deg);
            }
        }

    </style>
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
                    <a href="{{ route('galeri.index') }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-arrow-circle-left"></i> Kembali</a>
                    @include('galeri.modal_jenis')
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" style="padding-right: 50px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jenis">Jenis Gambar</label>
                                            <select class="form-control" id="select2" name="id_jenis_gambar">
                                                @foreach ($jenis as $jenis)
                                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_gambar }}
                                                    </option>
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
                                                <input type="file" id="file-input" onchange="loadPreview(this)"
                                                    name="image[]" multiple />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 sketchy text-center">
                                <p style="font-size: 20px; margin: 0 0px;">Preview Image</p>
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                <div id="thumb-output"></div>
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
        function loadPreview(input) {
            var data = $(input)[0].files; //this file data
            $.each(data, function(index, file) {
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                    var fRead = new FileReader();
                    fRead.onload = (function(file) {
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target
                                .result); //create image thumb element
                            $('#thumb-output').append(img);
                        };
                    })(file);
                    fRead.readAsDataURL(file);
                }
            });
        }

    </script>
@endsection
