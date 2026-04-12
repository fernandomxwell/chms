@php
    $active = isMenuRouteActive($menu);
@endphp

<li class="nav-item">
    @if ($menu->children->isEmpty())
        <a class="nav-link text-nowrap {{ $active ? 'text-dark' : 'text-muted' }}" href="{{ route($menu->link) }}">
            @lang($menu->name_in_snake_case . '.index')
        </a>
    @else
        <a class="nav-link text-nowrap {{ $active ? 'text-dark' : 'collapsed text-muted' }}" data-bs-toggle="collapse"
            href="#collapseDropdown{{ $menu->id }}" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}"
            aria-controls="collapseDropdown{{ $menu->id }}">
            @lang($menu->name_in_snake_case . '.index')
        </a>

        <div class="collapse ps-3 {{ $active ? 'show' : '' }}" id="collapseDropdown{{ $menu->id }}">
            <ul class="nav flex-column">
                @foreach ($menu->children as $child)
                    @include('layouts.sidebar-item', ['menu' => $child])
                @endforeach
            </ul>
        </div>
    @endif
</li>
