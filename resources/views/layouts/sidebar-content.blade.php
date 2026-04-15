<ul class="nav nav-pills flex-column">
    @if (request()->get('menus') && request()->get('menus')->isNotEmpty())
        @foreach (request()->get('menus') as $menu)
            @include('layouts.sidebar-item', ['menu' => $menu])
        @endforeach
    @endif

    @auth
        <li class="nav-item d-lg-none mt-3 border-top">
            <a class="nav-link text-nowrap collapsed text-muted" data-bs-toggle="collapse"
                href="#sidebarProfileDropdown" role="button" aria-expanded="false"
                aria-controls="sidebarProfileDropdown">
                {{ strtok(Auth::user()->name, ' ') }}
            </a>

            <div class="collapse ps-3" id="sidebarProfileDropdown">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-link text-muted" type="submit">
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    @endauth
</ul>
