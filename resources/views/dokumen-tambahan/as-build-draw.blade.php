<div class="modal fade" id="as-build-drawing" tabindex="-1" aria-labelledby="asBuildDrawingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asBuildDrawingModalLabel">Dokumen As Build Drawing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Upload form As Build Drawing -->
                    <form id="formAsBuildDrawing" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_as_build_drawing">Dokumen As Build Drawing</label>
                            <input type="file" accept="application/pdf" class="form-control"
                                id="dokumen_as_build_drawing" name="dokumen_as_build_drawing">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>