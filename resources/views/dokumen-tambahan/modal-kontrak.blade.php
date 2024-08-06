<div class="modal fade" id="dokumen-kontrak" tabindex="-1" aria-labelledby="dokumenKontrakModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokumenKontrakModalLabel">Dokumen Kontrak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Upload form dokumen kontrak -->
                    <form id="formDokumenKontrak" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_kontrak">Dokumen Kontrak</label>
                            <input type="file" accept="application/pdf" class="form-control" id="dokumen_kontrak"
                                name="dokumen_kontrak">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>