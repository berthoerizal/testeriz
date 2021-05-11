@if ($soal->status_soal == 'draft')
    <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#tambahModal">
        <i class="fa fa-plus"></i>
        Pertanyaan
    </a>
@else
    <a class="btn btn-primary btn-sm disabled" href="#">
        <i class="fa fa-plus"></i>
        Pertanyaan
    </a>
@endif
<!-- Tambah Modal-->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pertanyaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('tanya.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_soal" value="{{ $soal->id }}" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <textarea name="pertanyaan" id="pertanyaan" class="form-control textarea-tinymce"
                                    height="100px"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gambar">Gambar</label><br />
                                <input type="file" id="gambar" name="gambar">
                            </div>
                            <div class="form-group">
                                <label for="pilihan1">Opsi 1</label>
                                <input type="text" class="form-control form-control-sm" name="pilihan1" id="pilihan1"
                                    placeholder="Opsi 1" value="{{ old('pilihan1') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pilihan2">Opsi 2</label>
                                <input type="text" class="form-control form-control-sm" name="pilihan2" id="pilihan2"
                                    placeholder="Opsi 2" value="{{ old('pilihan2') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pilihan3">Opsi 3</label>
                                <input type="text" class="form-control form-control-sm" name="pilihan3" id="pilihan3"
                                    placeholder="Opsi 3" value="{{ old('pilihan3') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pilihan3">Opsi 4</label>
                                <input type="text" class="form-control form-control-sm" name="pilihan4" id="pilihan4"
                                    placeholder="Opsi 4" value="{{ old('pilihan4') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jawaban_benar">Pilih Jawaban Benar</label>
                                <select name="jawaban" class="form-control form-control-sm">
                                    <option value="pilihan1">Opsi 1</option>
                                    <option value="pilihan2">Opsi 2</option>
                                    <option value="pilihan3">Opsi 3</option>
                                    <option value="pilihan4">Opsi 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
