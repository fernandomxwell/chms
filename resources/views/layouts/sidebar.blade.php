<style>
    .nav-link.collapsed::after {
        content: " ▸";
    }

    .nav-link[aria-expanded="true"]::after {
        content: " ▾";
    }
</style>

{{-- Mobile Sidebar using Offcanvas --}}
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ config('app.name') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @include('layouts.sidebar-content')
    </div>
</div>

{{-- Static Sidebar for Desktop --}}
<nav class="d-none d-lg-block col-lg-2 bg-light sidebar position-fixed vh-100">
    <div class="pt-3 px-3">
        @include('layouts.sidebar-content')
    </div>
</nav>
