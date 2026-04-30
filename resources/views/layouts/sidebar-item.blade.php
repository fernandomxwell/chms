@php $active = isMenuRouteActive($menu); @endphp

<li class="sidebar-nav-item">
    @if ($menu->children->isEmpty())
        <a class="sidebar-nav-link {{ $active ? 'active' : '' }}"
            href="{{ route($menu->link) }}">
            @lang($menu->name_in_snake_case . '.index')
        </a>
    @else
        <a class="sidebar-group-toggle {{ $active ? 'active' : '' }}"
            data-bs-toggle="collapse"
            href="#sidebarGroup{{ $menu->id }}"
            role="button"
            aria-expanded="{{ $active ? 'true' : 'false' }}"
            aria-controls="sidebarGroup{{ $menu->id }}">
            <span>@lang($menu->name_in_snake_case . '.index')</span>
            <i class="bi bi-chevron-right toggle-arrow"></i>
        </a>

        <div class="collapse sidebar-children {{ $active ? 'show' : '' }}"
            id="sidebarGroup{{ $menu->id }}">
            <ul class="sidebar-nav">
                @foreach ($menu->children as $child)
                    @include('layouts.sidebar-item', ['menu' => $child])
                @endforeach
            </ul>
        </div>
    @endif
</li>
