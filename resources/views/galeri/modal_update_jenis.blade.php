<!-- Small modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm"><i
        class="fa fa-plus-circle"></i> Tambah Jenis Gambar</button>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Gambar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('update_jenis', [$galeri->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Jenis Gambar</label>
                        <input type="text" class="form-control form-control-sm" name="nama_jenis_gambar"
                            id="nama_jenis_gambar" placeholder="Nama Jenis Gambar"
                            value="{{ old('nama_jenis_gambar') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
