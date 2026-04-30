@if (request()->get('breadcrumbs') && request()->get('breadcrumbs')->isNotEmpty())
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home.index') }}">@lang('home.index')</a>
            </li>
            @foreach(request()->get('breadcrumbs') as $crumb)
                @if($crumb->link === 'home.index') @continue @endif
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $crumb->translated_name }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        @if(!empty($crumb->link) && Route::has($crumb->link))
                            <a href="{{ route($crumb->link) }}">{{ $crumb->translated_name }}</a>
                        @else
                            <span>{{ $crumb->translated_name }}</span>
                        @endif
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
