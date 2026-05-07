@extends('layouts.app')

@section('content')
    <h1>@lang('roles.index')</h1>

    @include('layouts.error')
    @include('layouts.success')

    <div class="d-flex flex-wrap gap-2 mb-2">
        <a class="btn btn-primary" href="{{ route('roles.create') }}">@lang('roles.create')</a>
    </div>

    <form action="{{ route('roles.index') }}" method="GET">
        <div class="row my-1">
            <div class="col-md-6 my-1 offset-md-6">
                <div class="input-group">
                    <input type="text" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search', request('search')) }}" maxlength="100" placeholder="@lang('search_by_name')">
                    <button class="btn btn-outline-secondary" type="submit">@lang('search')</button>
                    @error('search')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="align-middle table-light">
                <tr>
                    <th class="text-nowrap">@lang('No')</th>
                    <th class="text-nowrap">@lang('name')</th>
                    <th class="text-nowrap">@lang('roles.permission_count')</th>
                    <th class="text-nowrap">@lang('actions')</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($roles as $index => $role)
                <tr>
                    <td>{{ paginatedIndex($index + 1, $roles->currentPage(), $roles->perPage()) }}</td>
                    <td>{!! highlightMatch($role->name, request('search')) !!}</td>
                    <td>{{ count($role->permissions ?? []) }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success mb-1">@lang('edit')</a>
                        <button type="button" class="btn btn-danger mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $role->id }}">
                            @lang('delete')
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">@lang('no_records_found')</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! $roles->links() !!}
    </div>

    @foreach ($roles as $role)
        <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">@lang('confirm_delete')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @lang('roles.are_you_sure')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('cancel')</button>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">@lang('delete')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
