@extends('layouts.app')

@section('content')
    <h1>@lang('service_types.show')</h1>

    <div class="form-group mb-3">
        <label class="form-label">@lang('name'):</label>
        <input type="text" class="form-control" value="{{ $serviceType->name }}" readonly>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('description'):</label>
        <textarea class="form-control" rows="10" readonly>{{ $serviceType->description }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('activities.index'):</label>
        <div>
            @forelse($serviceType->activities as $activity)
                <span class="badge bg-info me-1">{{ $activity->name }}</span>
            @empty
                <span class="text-muted">@lang('no_activities_assigned')</span>
            @endforelse
        </div>
    </div>

    <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
@endsection
