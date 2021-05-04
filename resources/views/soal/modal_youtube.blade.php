<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
    data-target="#exampleModalCenter{{ $soal->id }}">
    <i class="fa fa-play"></i> Materi Video
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{ $soal->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $soal->judul_soal }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-0 p-0">
                <div class="embed-responsive embed-responsive-1by1">
                    <iframe width="420" height="315" src="https://www.youtube.com/embed/{{ $soal->materi_video }}"
                        frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
