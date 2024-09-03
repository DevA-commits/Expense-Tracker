<!-- delete Modal -->
<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ 'Delete Confirmation' }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h6 class="mt-1">Are you sure you want to delete this expense? Deleting this expense will restore the amount of your total balance.</h6>
                <p class="bg-danger text-white p-2">This action cannot be undone.</p>
                <input type="hidden" id="confirm_url">
                <input type="hidden" id="refresh_table_name">
                <button type="button" class="btn btn-default mt-2" data-bs-dismiss="modal">{{ 'Cancel' }}</button>
                <span onclick="deleteData()" id="delete-link" class="btn btn-primary mt-2">{{ 'Delete' }}</span>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
