@extends('layouts.app')

@section('content')
    <h1>@lang('congregant_services.edit')</h1>

    <form action="{{ route('congregant_services.update', $congregant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="congregant_id" class="form-label">@lang('congregants.index'):</label>
            <select class="form-select @error('congregant_id') is-invalid @enderror" id="congregant_id" name="congregant_id" disabled></select>
            @error('congregant_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="accordion mb-3">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        @lang('activities.index')
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <div class="row">
                            @foreach($activities as $activity)
                                <div class="col-md-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('activity_ids') is-invalid @enderror" type="checkbox" name="activity_ids[]" value="{{ $activity->id }}" {{ in_array($activity->id, old('activity_ids', $congregant->activities->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $activity->name }}">{{ $activity->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                            @error('activity_ids')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                            @error('activity_ids.*')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        @lang('service_types.index')
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                        <div class="row">
                            @foreach($serviceTypes as $serviceType)
                                <div class="col-md-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('service_type_ids') is-invalid @enderror" type="checkbox" name="service_type_ids[]" value="{{ $serviceType->id }}" {{ in_array($serviceType->id, old('service_type_ids', $congregant->serviceTypes->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $serviceType->name }}">{{ $serviceType->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                            @error('service_type_ids')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                            @error('service_type_ids.*')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="hidden" name="can_serve_consecutively" value="0">
                
                <input class="form-check-input" type="checkbox" name="can_serve_consecutively" value="1" id="can_serve_consecutively" 
                    @if(old('can_serve_consecutively', $congregant->can_serve_consecutively)) checked @endif
                >
                <label class="form-check-label" for="can_serve_consecutively">
                    @lang('willing_to_serve')
                </label>
            </div>
            @error('can_serve_consecutively')
                <div class="small text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">@lang('submit')</button>

        <a class="btn btn-secondary" href="{{ url()->previous() }}">@lang('back')</a>
    </form>
@endsection

@section('javascript')
    <script>
        let defaultOption = {
            id: {{ $congregant->id }},
            text: " {{ $congregant->full_name }}"
        };
        let newOption = new Option(defaultOption.text, defaultOption.id, true, true);
        $('#congregant_id').append(newOption).trigger('change');
    </script>
@endsection