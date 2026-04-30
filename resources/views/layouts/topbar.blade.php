<header class="app-topbar">
    {{-- Mobile sidebar toggle --}}
    <button class="app-sidebar-toggle d-lg-none" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
        aria-label="Toggle navigation">
        <i class="bi bi-list" style="font-size:1.125rem;"></i>
    </button>

    <a class="app-topbar-brand d-lg-none" href="{{ route('home.index') }}">
        {{ config('app.name') }}
    </a>

    <div class="app-topbar-spacer"></div>

    @auth
        <div class="dropdown">
            <button class="app-topbar-user dropdown-toggle" id="topbarProfileDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" type="button">
                <span class="app-topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <span class="d-none d-sm-inline">{{ strtok(Auth::user()->name, ' ') }}</span>
                <i class="bi bi-chevron-down" style="font-size:.625rem; opacity:.6;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="topbarProfileDropdown">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('auth.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth
</header>
