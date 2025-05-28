<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rese 飲食店予約')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="header-container">
            @php
                $isAdminOrOwnerPage = request()->is('admin*') || request()->is('owner*');
            @endphp

            <div class="left-group">
                @unless($isAdminOrOwnerPage)
                    <button class="menu-icon" id="menuToggle">☰</button>
                @endunless

                <h1 class="logo">
                    @unless($isAdminOrOwnerPage)
                        <a href="{{ route('home') }}">Rese</a>
                    @else
                        <span class="disabled-logo">Rese</span>
                    @endunless
                </h1>
            </div>
                <div class="right-group">
                    <div class="header-extra">
                        @yield('header')
                    </div>
                </div>
            </div>

            <div class="menu-panel" id="menuPanel">
                <button class="menu-close" id="menuClose">✖</button>
                <nav class="menu-links">
                    <a href="{{ route('home') }}">Home</a>
                    @auth
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        <a href="{{ route('mypage') }}">Mypage</a>
                    @else
                        <a href="{{ route('register') }}">Registration</a>
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </nav>
            </div>

        </header>

        <main class="main-content">
            @yield('content')
        </main>

        <script>
            const toggleBtn = document.getElementById('menuToggle');
            const closeBtn = document.getElementById('menuClose');
            const menuPanel = document.getElementById('menuPanel');

            toggleBtn.addEventListener('click', () => {
                menuPanel.classList.add('show');
            });

            closeBtn.addEventListener('click', () => {
                menuPanel.classList.remove('show');
            });

            document.addEventListener('click', function (event) {
                const isClickInside = menuPanel.contains(event.target) || toggleBtn.contains(event.target);
                if (!isClickInside) {
                    menuPanel.classList.remove('show');
                }
            });
        </script>

        @yield('scripts')
        @stack('scripts')
    </div>
</body>

</html>