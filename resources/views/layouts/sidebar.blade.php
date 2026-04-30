{{-- Mobile: Offcanvas --}}
<div class="offcanvas offcanvas-start app-offcanvas-sidebar d-lg-none"
    tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ config('app.name') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @include('layouts.sidebar-content')
    </div>
</div>

{{-- Desktop: Fixed sidebar --}}
<aside class="app-sidebar d-none d-lg-flex">
    <div class="app-sidebar-header">
        <a class="app-sidebar-logo" href="{{ route('home.index') }}">
            {{ config('app.name') }}
        </a>
    </div>
    <div class="app-sidebar-body">
        @include('layouts.sidebar-content')
    </div>
    @auth
    <div class="app-sidebar-footer">
        <div class="dropdown">
            <button class="sidebar-nav-link w-100 d-flex align-items-center gap-2 dropdown-toggle"
                id="sidebarUserDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button"
                style="text-decoration:none;">
                <span class="app-topbar-avatar" style="background:rgba(99,102,241,.25);color:#a5b4fc;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <span class="text-truncate" style="font-size:.8125rem; color:#cbd5e1; max-width:140px;">
                    {{ Auth::user()->name }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarUserDropdown"
                style="background:#1e293b; border-color:rgba(255,255,255,.1);">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit"
                            style="color:#f87171;">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('auth.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    @endauth
</aside>
