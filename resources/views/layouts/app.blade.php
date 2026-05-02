<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @yield('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @auth
        {{-- Topbar --}}
        @include('layouts.topbar')

        <div class="app-content-wrapper">
            {{-- Desktop Sidebar --}}
            @include('layouts.sidebar')

            {{-- Main --}}
            <main>
                <div class="app-content">
                    @include('layouts.breadcrumb')
                    @yield('content')
                    @include('layouts.footer')
                </div>
            </main>
        </div>
    @else
        {{-- Unauthenticated (login page) --}}
        @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Close topbar user dropdown on show (prevents stale aria state)
        const _tpDrop = document.getElementById('topbarProfileDropdown');
        if (_tpDrop) {
            _tpDrop.addEventListener('shown.bs.dropdown', function () {
                this.setAttribute('aria-expanded', 'false');
            });
        }

        // Search field clear button
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[name="search"]').forEach(function (input) {
                const group = input.closest('.input-group');
                if (!group) return;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-secondary search-clear-btn';
                btn.innerHTML = '<i class="bi bi-x-lg"></i>';
                btn.style.display = input.value ? '' : 'none';
                input.after(btn);

                input.addEventListener('input', function () {
                    btn.style.display = this.value ? '' : 'none';
                });

                btn.addEventListener('click', function () {
                    input.value = '';
                    btn.style.display = 'none';
                    input.form && input.form.submit();
                });
            });
        });
    </script>
    @yield('javascript')
</body>
</html>
