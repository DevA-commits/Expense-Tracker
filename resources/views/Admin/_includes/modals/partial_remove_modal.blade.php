<!-- delete Modal -->
<div id="partial-remove-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ 'Remove Confirmation' }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{ 'Are you sure to remove this?' }}</p>
                <div id="item_data">
                </div>
                <input type="hidden" id="class_name">
                <button type="button" class="btn btn-default mt-2" data-bs-dismiss="modal">{{ 'Cancel' }}</button>
                <span onclick="removeItem()" id="delete-link" class="btn btn-primary mt-2">{{ 'Remove' }}</span>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

