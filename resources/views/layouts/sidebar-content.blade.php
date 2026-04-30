<ul class="sidebar-nav">
    @if (request()->get('menus') && request()->get('menus')->isNotEmpty())
        @foreach (request()->get('menus') as $menu)
            @include('layouts.sidebar-item', ['menu' => $menu])
        @endforeach
    @endif
</ul>
