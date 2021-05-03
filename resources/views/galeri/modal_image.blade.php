<!-- Button trigger modal -->
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModalCenter{{ $galeri->id }}">
    <img src="{{ asset('assets/images/' . $galeri->gambar) }}" class="img img-responsive img-thumbnail" width="100px">
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{ $galeri->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $galeri->nama_jenis_gambar }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-0 p-0">
                <img src="{{ asset('assets/images/' . $galeri->gambar) }}" alt="" style="width:100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
