<!-- Modal -->
<div class="modal fade flip" id="confirm-modal" tabindex="-1" aria-labelledby="deleteOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">

                <lord-icon src="https://cdn.lordicon.com/dnmvmpfk.json" trigger="loop" colors="primary:#982876"
                    style="width:90px;height:90px">
                </lord-icon>
                <div class="mt-4 text-center">
                    <h4>You are about to confirm a action ?</h4>
                    <p class="text-muted fs-15 mb-4">Confirm your action will change all of your information from our
                        database.</p>
                    <div class="hstack gap-2 justify-content-center remove">
                        <input type="hidden" id="confirm_url">
                        <input type="hidden" id="refresh_table_name">
                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close"
                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                        <button class="btn btn-primary" onclick="confirmData()" id="delete-link">Yes, Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modal -->
