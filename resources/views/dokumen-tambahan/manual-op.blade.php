<!-- Modal for Manual OP -->
<div class="modal fade" id="manual-op" tabindex="-1" role="dialog" aria-labelledby="manualOpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualOpLabel">Upload Dokumen Manual OP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formManualOp" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="manual-op">Pilih Dokumen:</label>
                        <input type="file" class="form-control" id="manual-op" name="dokumen_manual_op" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>