<a class="btn btn-dark btn-sm" href="#" data-toggle="modal" data-target="#selesaiUjian">
    <i class="fa fa-arrow-right"></i>
    Selesai Ujian
</a>
<!-- Tambah Modal-->
<div class="modal fade" id="selesaiUjian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selesai Ujian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menyelesaikan ujian <b>{{ $soal->judul_soal }}</b> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <a href="{{ route('selesai_ujian', ['id_soal' => $soal->id]) }}" class="btn btn-dark btn-sm">Yakin</a>
            </div>
        </div>
    </div>
</div>
