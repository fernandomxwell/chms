@extends('layouts.app')

@section('content')
    <h1>@lang('roles.create')</h1>

    @include('layouts.error')

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">@lang('name'):</label>
            <input type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                maxlength="255"
                required
                autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @include('roles.partials.permissions', ['selectedPermissions' => []])

        <button type="submit" class="btn btn-primary">@lang('submit')</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
    </form>
@endsection
