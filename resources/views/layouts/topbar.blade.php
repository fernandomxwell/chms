<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
    <div class="container-fluid">
        {{-- Sidebar toggle button for small screens --}}
        <button class="btn d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="#">{{ config('app.name') }}</a>

        @auth
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav navbar-expand-lg ms-auto sticky-top">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ strtok(Auth::user()->name, ' ') }}</a>
                    </li>
                    <div class="vr d-none d-lg-block"></div>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-link" type="submit">
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
