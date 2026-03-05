<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookTix') — Find & Book Events</title>
    <meta name="description" content="@yield('meta_description', 'Discover and book tickets for amazing events near you.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── CSS VARIABLES ── */
        :root {
            --bg:          #fafaf9;
            --bg-2:        #f5f5f3;
            --surface:     #ffffff;
            --border:      #e7e5e4;
            --border-2:    #d6d3d1;
            --text:        #1c1917;
            --text-2:      #57534e;
            --text-3:      #a8a29e;
            --accent:      #6366f1;
            --accent-dark: #4f46e5;
            --accent-soft: #eef2ff;
            --nav-bg:      rgba(250,250,249,0.85);
            --shadow:      0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:   0 4px 20px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
            --radius:      12px;
        }

        [data-theme="dark"] {
            --bg:          #0f0f0e;
            --bg-2:        #1a1916;
            --surface:     #1c1917;
            --border:      #292524;
            --border-2:    #3d3935;
            --text:        #fafaf9;
            --text-2:      #a8a29e;
            --text-3:      #57534e;
            --accent:      #818cf8;
            --accent-dark: #6366f1;
            --accent-soft: #1e1b4b;
            --nav-bg:      rgba(15,15,14,0.85);
            --shadow:      0 1px 3px rgba(0,0,0,0.3);
            --shadow-md:   0 4px 20px rgba(0,0,0,0.4);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { background: var(--bg); }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            transition: background 0.2s, color 0.2s;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            height: 64px;
            background: var(--nav-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: background 0.2s, border-color 0.2s;
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-mark {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
            box-shadow: 0 2px 8px rgba(99,102,241,0.35);
        }

        .brand-text {
            font-family: 'Fraunces', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .brand-text span { color: var(--accent); }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link {
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
            transition: all 0.15s;
        }

        .nav-link:hover {
            background: var(--bg-2);
            color: var(--text);
        }

        .nav-link.active {
            background: var(--accent-soft);
            color: var(--accent);
        }

        /* Nav right */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Dark mode toggle */
        .theme-toggle {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-2);
            transition: all 0.15s;
        }

        .theme-toggle:hover {
            background: var(--bg-2);
            color: var(--text);
        }

        .icon-sun, .icon-moon { display: none; }
        [data-theme="dark"] .icon-moon { display: block; }
        [data-theme="light"] .icon-sun  { display: block; }

        /* Auth buttons */
        .btn-ghost {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
        }

        .btn-ghost:hover {
            background: var(--bg-2);
            color: var(--text);
        }

        .btn-accent {
            padding: 7px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            text-decoration: none;
            background: var(--accent);
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3);
        }

        .btn-accent:hover {
            background: var(--accent-dark);
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
            transform: translateY(-1px);
        }

        /* User menu */
        .user-menu {
            position: relative;
        }

        .user-trigger {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 12px 5px 5px;
            border-radius: 30px;
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .user-trigger:hover {
            border-color: var(--border-2);
            box-shadow: var(--shadow);
        }

        .user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Fraunces', serif;
            font-size: 11px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 200px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            padding: 6px;
            display: none;
            z-index: 200;
        }

        .dropdown.open { display: block; }

        .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
            transition: all 0.12s;
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            text-align: left;
        }

        .dropdown-item:hover {
            background: var(--bg-2);
            color: var(--text);
        }

        .dropdown-item.danger { color: #ef4444; }
        .dropdown-item.danger:hover { background: #fff5f5; }

        [data-theme="dark"] .dropdown-item.danger:hover { background: #2d0a0a; }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            padding-top: 64px;
            min-height: 100vh;
        }

        /* ── FLASH MESSAGES ── */
        .flash-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 24px 0;
        }

        .flash {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 4px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .flash-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .flash-error {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        [data-theme="dark"] .flash-success { background: #052e16; border-color: #166534; color: #4ade80; }
        [data-theme="dark"] .flash-error   { background: #2d0a0a; border-color: #7f1d1d; color: #f87171; }

        /* ── FOOTER ── */
        .footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 40px 24px;
            margin-top: 80px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-brand {
            display: flex; align-items: center; gap: 8px;
            text-decoration: none;
        }

        .footer-copy {
            font-size: 13px;
            color: var(--text-3);
        }

        .footer-links {
            display: flex; gap: 20px;
        }

        .footer-link {
            font-size: 13px;
            color: var(--text-3);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-link:hover { color: var(--text-2); }

        /* Mobile nav toggle */
        .mobile-menu-btn {
            display: none;
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-2);
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu-btn { display: flex; }
            .user-name { display: none; }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-inner">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="nav-brand">
                <div class="brand-mark">🎟️</div>
                <div class="brand-text">Book<span>Tix</span></div>
            </a>

            <!-- Nav Links -->
            <div class="nav-links">
                <a href="{{ url('/') }}"
                   class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('events.index') }}"
                   class="nav-link {{ request()->is('events*') ? 'active' : '' }}">
                    Events
                </a>
                @auth
                <a href="{{ route('orders.index') }}"
                   class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                    My Orders
                </a>
                @endauth
            </div>

            <!-- Right Side -->
            <div class="nav-right">
                <!-- Dark Mode Toggle -->
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                    <svg class="icon-sun" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5"/>
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <svg class="icon-moon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>

                @auth
                    <!-- User Dropdown -->
                    <div class="user-menu" id="userMenu">
                        <div class="user-trigger" onclick="toggleDropdown()">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-3);">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>

                        <div class="dropdown" id="dropdown">
                            <a href="{{ route('orders.index') }}" class="dropdown-item">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/>
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                                Profile
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                                </svg>
                                Admin Panel
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Login</a>
                    <a href="{{ route('register') }}" class="btn-accent">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- Flash Messages -->
        @if(session('success') || session('error'))
        <div class="flash-container">
            @if(session('success'))
            <div class="flash flash-success">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash flash-error">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>
        @endif

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <a href="{{ url('/') }}" class="footer-brand">
                <div class="brand-mark" style="width:28px;height:28px;font-size:14px;">🎟️</div>
                <span style="font-family:'Fraunces',serif;font-size:16px;font-weight:700;color:var(--text);">
                    Book<span style="color:var(--accent);">Tix</span>
                </span>
            </a>
            <span class="footer-copy">© {{ date('Y') }} BookTix. All rights reserved.</span>
            <div class="footer-links">
                <a href="#" class="footer-link">About</a>
                <a href="#" class="footer-link">Privacy</a>
                <a href="#" class="footer-link">Terms</a>
            </div>
        </div>
    </footer>

    <script>
        // ── THEME ──
        const savedTheme = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', savedTheme);

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        }

        // ── DROPDOWN ──
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu');
            if (menu && !menu.contains(e.target)) {
                document.getElementById('dropdown')?.classList.remove('open');
            }
        });
    </script>
</body>
</html>