<div class="modal fade" id="pho-fho" tabindex="-1" aria-labelledby="phoFhoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoFhoModalLabel">Dokumen PHO/FHO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Upload form PHO/FHO -->
                    <form id="formPhoFho" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_pho_fho">Dokumen PHO/FHO</label>
                            <input type="file" accept="application/pdf" class="form-control" id="dokumen_pho_fho"
                                name="dokumen_pho_fho">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>