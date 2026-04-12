@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <h1>@lang('schedules.create')</h1>

    <form action="{{ route('schedules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="activity_id" class="form-label">@lang('activities.index'):</label>
            <select class="form-select @error('activity_id') is-invalid @enderror" id="activity_id" name="activity_id" required></select>
            @error('activity_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="start_date" class="form-label">@lang('start_date'):</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror" required min="{{ now()->format('Y-m-d') }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="end_date" class="form-label">@lang('end_date'):</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror" required min="{{ now()->format('Y-m-d') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="mb-3">
            <div class="table-responsive">
                <table class="table table-borderless table-sm align-middle">
                    <thead>
                        <tr>
                            <th>@lang('service_types.index')</th>
                            <th class="text-center">@lang('include')?</th>
                            <th style="width: 100px;">@lang('count')</th>
                            <th style="width: 150px;" class="text-center">@lang('repeatable')?</th> <!-- Diubah -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceTypes as $serviceType)
                            <tr>
                                <td>{{ $serviceType->name }}</td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline d-flex justify-content-center">
                                        <input class="form-check-input @error("service_types.{$serviceType->id}.include") is-invalid @enderror" type="checkbox"
                                            name="service_types[{{ $serviceType->id }}][include]" value="1"
                                            id="include_{{ $serviceType->id }}"
                                            {{ old("service_types.{$serviceType->id}.include") ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <input type="number"
                                        name="service_types[{{ $serviceType->id }}][count]"
                                        class="form-control @error("service_types.{$serviceType->id}.count") is-invalid @enderror"
                                        min="1"
                                        value="{{ old("service_types.{$serviceType->id}.count", 1) }}">
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline d-flex justify-content-center">
                                        <input class="form-check-input @error("service_types.{$serviceType->id}.is_repeatable") is-invalid @enderror" type="checkbox"
                                            name="service_types[{{ $serviceType->id }}][is_repeatable]" value="1"
                                            id="is_repeatable_{{ $serviceType->id }}"
                                            {{ old("service_types.{$serviceType->id}.is_repeatable") ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2">
                                @error('service_types.*.include')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                @error('service_types.*.count')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                @error('service_types.*.is_repeatable')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">@lang('generate')</button>

                <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#activity_id').select2({
            placeholder: "{{ __('choose') }}...",
            allowClear: true,
            ajax: {
                url: "{{ route('ajax.activities') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page || 1
                    };
                },
                processResults: function (data, $params) {
                    allowInitialLoad = false; // disable after first load

                    return {
                        results: data.items,
                        pagination: {
                            more: data.pagination.more
                        }
                    };

                },
                cache: true
            },
        });
    </script>
@endsection