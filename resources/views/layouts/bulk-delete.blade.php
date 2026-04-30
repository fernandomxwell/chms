{{-- Params: $bulkDeleteConfirmText (string) --}}

<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-trash3 text-danger me-2"></i>@lang('confirm_delete')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary">
                {{ $bulkDeleteConfirmText }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @lang('cancel')
                </button>
                <button type="submit" form="bulk-form" class="btn btn-danger">
                    <i class="bi bi-trash3 me-1"></i>@lang('delete')
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('bulk-select-all');
    const getCheckboxes = () => document.querySelectorAll('.bulk-checkbox');
    const deleteBtn = document.getElementById('bulk-delete-btn');
    const countSpan = document.getElementById('bulk-selected-count');

    function updateState() {
        const all = getCheckboxes();
        const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
        countSpan.textContent = checked;
        deleteBtn.disabled = checked === 0;
        if (selectAll) {
            selectAll.indeterminate = checked > 0 && checked < all.length;
            selectAll.checked = all.length > 0 && checked === all.length;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            getCheckboxes().forEach(cb => cb.checked = this.checked);
            updateState();
        });
    }

    getCheckboxes().forEach(cb => cb.addEventListener('change', updateState));
    updateState();
});
</script>
