@extends('layouts.app')

@section('content')
    <h1>@lang('activities.index')</h1>

    @include('layouts.error')
    @include('layouts.success')

    <a class="btn btn-primary mb-3" href="{{ route('activities.create') }}">@lang('activities.create')</a>

    <form action="{{ route('activities.index') }}" method="GET">
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
                    <th class="text-nowrap">@lang('start_time')</th>
                    <th class="text-nowrap">@lang('recurrence_summary')</th>
                    <th class="text-nowrap">@lang('actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $index => $activity)
                    <tr>
                        <td>{{ paginatedIndex($index + 1, $activities->currentPage(), $activities->perPage()) }}</td>
                        <td>{!! highlightMatch($activity->name, request('search')) !!}</td>
                        <td class="text-nowrap">{{ $activity->start_time }}</td>
                        <td>{{ $recurrenceSummaries[$activity->id] }}</td>
                        <td class="text-nowrap">
                            <a class="btn btn-info text-light mr-1 mb-1" href="{{ route('activities.show', $activity->id) }}">@lang('show')</a>
                            <a class="btn btn-success mr-1 mb-1" href="{{ route('activities.edit', $activity->id) }}">@lang('edit')</a>
                            <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $activity->id }}">@lang('delete')</button>

                            <div class="modal fade" id="deleteModal{{ $activity->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $activity->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $activity->id }}">@lang('confirm_delete')</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @lang('activities.are_you_sure')
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('cancel')</button>
                                            <form action="{{ route('activities.destroy', $activity->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">@lang('delete')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">@lang('no_records_found')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $activities->links() !!}
    </div>
@endsection
