<div class="mb-3">
    <label class="form-label">@lang('roles.permissions'):</label>
    <div class="row row-cols-1 row-cols-md-2 g-3">
        @foreach ($allPermissions as $group)
            @php $groupIndex = $loop->index; @endphp
            <div class="col">
                <div class="form-check fw-semibold mb-1">
                    <input class="form-check-input perm-group-all" type="checkbox"
                        id="perm_group_{{ $groupIndex }}"
                        data-group="{{ $groupIndex }}">
                    <label class="form-check-label" for="perm_group_{{ $groupIndex }}">
                        {{ $group['label'] }}
                    </label>
                </div>
                <div class="ms-3">
                    @foreach ($group['permissions'] as $permission)
                        @php
                            $permIndex = $groupIndex . '_' . $loop->index;
                            $action = substr($permission, strrpos($permission, '.') + 1);
                        @endphp
                        <div class="form-check">
                            <input class="form-check-input perm-item" type="checkbox"
                                name="permissions[]"
                                value="{{ $permission }}"
                                id="perm_{{ $permIndex }}"
                                data-group="{{ $groupIndex }}"
                                {{ in_array($permission, old('permissions', $selectedPermissions)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permIndex }}">
                                @lang($action)
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function syncGroupCheckbox(groupIndex) {
        const items = document.querySelectorAll(`.perm-item[data-group="${groupIndex}"]`);
        const groupAll = document.querySelector(`.perm-group-all[data-group="${groupIndex}"]`);
        const checkedCount = [...items].filter(i => i.checked).length;
        groupAll.checked = checkedCount === items.length;
        groupAll.indeterminate = checkedCount > 0 && checkedCount < items.length;
    }

    document.querySelectorAll('.perm-group-all').forEach(function (groupAll) {
        const groupIndex = groupAll.dataset.group;

        syncGroupCheckbox(groupIndex);

        groupAll.addEventListener('change', function () {
            document.querySelectorAll(`.perm-item[data-group="${groupIndex}"]`)
                .forEach(item => item.checked = this.checked);
        });
    });

    document.querySelectorAll('.perm-item').forEach(function (item) {
        item.addEventListener('change', function () {
            syncGroupCheckbox(this.dataset.group);
        });
    });
});
</script>
@endsection
