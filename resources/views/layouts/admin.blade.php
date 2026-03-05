<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — BookTix</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-bg: #0f1117;
            --sidebar-border: rgba(255,255,255,0.06);
            --accent: #6366f1;
            --accent-light: #818cf8;
            --accent-glow: rgba(99,102,241,0.15);
            --text-muted: #6b7280;
            --surface: #ffffff;
            --surface-2: #f8f9fc;
            --border: #e5e7eb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface-2);
            color: #111827;
            min-height: 100vh;
        }

        /* ── LAYOUT ── */
        .layout { display: flex; height: 100vh; overflow: hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--sidebar-border);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 240px; height: 240px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-brand {
            height: 68px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid var(--sidebar-border);
            gap: 10px;
        }

        .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            box-shadow: 0 0 20px rgba(99,102,241,0.4);
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #ffffff;
            letter-spacing: -0.3px;
        }

        .brand-name span {
            color: var(--accent-light);
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #374151;
            padding: 8px 10px 6px;
            margin-top: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 10px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.18s ease;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #e5e7eb;
        }

        .nav-link.active {
            background: var(--accent-glow);
            color: var(--accent-light);
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 20px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 18px; height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-link.active .nav-icon { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            line-height: 1.6;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--sidebar-border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: #e5e7eb;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role {
            font-size: 11px;
            color: #6b7280;
            margin-top: 1px;
        }

        /* ── MAIN ── */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: 68px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.3px;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-btn {
            display: flex; align-items: center; justify-content: center;
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.15s;
        }

        .topbar-btn:hover { background: var(--surface-2); color: #374151; }

        .logout-btn {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1px solid #fecaca;
            background: #fff5f5;
            color: #dc2626;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            border-color: #fca5a5;
        }

        /* ── CONTENT ── */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
        }

        .content-area::-webkit-scrollbar { width: 4px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }

        /* ── FLASH MESSAGES ── */
        .flash {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
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
    </style>
</head>

<body>
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🎪</div>
            <div class="brand-name">Book<span>Tix</span></div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Overview</span>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <span class="nav-section-label">Management</span>

            <a href="{{ route('admin.events.index') }}"
               class="nav-link {{ request()->is('admin/events*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                </svg>
                Events
            </a>

            <a href="{{ route('admin.orders.index') }}"
                class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                Orders
                @if(isset($pendingOrderCount) && $pendingOrderCount > 0)
                    <span class="nav-badge">{{ $pendingOrderCount }}</span>
                @endif
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="main-area">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <div class="page-title">@yield('title', 'Dashboard')</div>
                <div class="breadcrumb">Admin / @yield('title', 'Dashboard')</div>
            </div>

            <div class="topbar-right">
                <button class="topbar-btn" title="Notifications">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                </button>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="content-area">
            @if(session('success'))
                <div class="flash flash-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash flash-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</div>
</body>
</html>