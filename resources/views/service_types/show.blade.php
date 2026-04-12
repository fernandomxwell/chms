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

    <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
@endsection
