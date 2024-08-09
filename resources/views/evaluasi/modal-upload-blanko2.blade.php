@foreach($items as $item)
<div class="modal fade" id="uploadModal{{ $item->id }}" tabindex="-1" aria-labelledby="uploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('inventarisasi-awal-data-informasi-non-fisik-upload-blanko', ['item' => $item->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File untuk {{ $item->nama_item }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="path_blanko" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach