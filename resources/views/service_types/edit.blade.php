@extends('layouts.app')

@section('content')
    <h1>@lang('service_types.edit')</h1>

    <form action="{{ route('service_types.update', $serviceType->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">@lang('name'):</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $serviceType->name) }}" maxlength="100" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">@lang('description'):</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="10">{{ old('description', $serviceType->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="activities" class="form-label">@lang('service_types.select_activities'):</label>
            <select name="activities[]" id="activities" class="formselect form-control" multiple>
                @foreach($activities as $activity)
                    <option value="{{ $activity->id }}" {{ $serviceType->activities->contains($activity->id) ? 'selected' : '' }}>{{ $activity->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">@lang('update')</button>

        <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
    </form>
@endsection
