<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h5 class="modal-title" id="productsName"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="fileUpload" method="post" id="videoUploadForm" enctype="multipart/form-data">


                    <div class="row justify-content-center">
                        <div id="drop-area" class="drop-area text-center p-4 border rounded">
                            <div class="drop-content">
                                <label class="btn btn-outline-primary btn-lg" for="filevideo">
                                    <i class="bi bi-upload me-1"></i> Select video
                                    <input type="file" id="filevideo" name="video" accept="video/*"
                                        class="filevideo d-none">

                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="productVideoId" name="product_id" value="">
                </form>

                <div class="mt-3" id="imagePreviewContainer">
                    <h6 class="text-center">Uploaded Video</h6>
                    <div id="videoPreview" class="d-flex flex-wrap justify-content-center gap-2">
                        
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>