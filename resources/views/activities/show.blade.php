@extends('layouts.app')

@section('content')
    <h1>@lang('activities.show')</h1>

    <div class="form-group mb-3">
        <label class="form-label">@lang('name'):</label>
        <input type="text" class="form-control" value="{{ $activity->name }}" readonly>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('description'):</label>
        <textarea class="form-control" readonly>{{ $activity->description }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('start_time'):</label>
        <input type="text" class="form-control" value="{{ $activity->start_time }}" readonly>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('recurrence_rule'):</label>
        <textarea class="form-control" readonly>{{ $activity->rrule }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">@lang('recurrence_summary'):</label>
        <input type="text" class="form-control" value="{{ $recurrenceSummary }}" readonly>
    </div>

    <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
@endsection
