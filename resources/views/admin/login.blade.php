<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — EventHub Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f1117;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 52%;
            background: #0f1117;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        /* decorative blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        .blob-1 {
            width: 400px; height: 400px;
            background: rgba(99,102,241,0.18);
            top: -100px; left: -100px;
        }

        .blob-2 {
            width: 300px; height: 300px;
            background: rgba(139,92,246,0.12);
            bottom: -60px; right: 60px;
        }

        .blob-3 {
            width: 200px; height: 200px;
            background: rgba(6,182,212,0.08);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        /* grid lines decoration */
        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 1;
            max-width: 420px;
            width: 100%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 56px;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 24px rgba(99,102,241,0.45);
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }

        .brand-name span { color: #818cf8; }

        .left-headline {
            font-family: 'Syne', sans-serif;
            font-size: 40px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .left-headline em {
            font-style: normal;
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-desc {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 48px;
        }

        /* feature list */
        .features {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-dot {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 13px;
            color: #9ca3af;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 48%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #e5e7eb 20%, #e5e7eb 80%, transparent);
        }

        .login-card {
            width: 100%;
            max-width: 380px;
        }

        .login-header {
            margin-bottom: 36px;
        }

        .login-title {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        /* ── FORM ── */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            color: #111827;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
            outline: none;
        }

        .form-input:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .form-input::placeholder { color: #9ca3af; }

        /* password field with toggle */
        .input-wrapper {
            position: relative;
        }

        .input-wrapper .form-input {
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 4px;
            display: flex; align-items: center; justify-content: center;
            transition: color 0.15s;
        }

        .toggle-password:hover { color: #6b7280; }

        /* remember + forgot row */
        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #6b7280;
        }

        .remember-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: #6366f1;
            cursor: pointer;
            border-radius: 4px;
        }

        .forgot-link {
            font-size: 13px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .forgot-link:hover { color: #4f46e5; }

        /* submit button */
        .submit-btn {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            background: #6366f1;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 10px rgba(99,102,241,0.35);
            letter-spacing: 0.1px;
        }

        .submit-btn:hover {
            background: #4f46e5;
            box-shadow: 0 4px 20px rgba(99,102,241,0.45);
            transform: translateY(-1px);
        }

        .submit-btn:active { transform: translateY(0); }

        /* error alert */
        .alert-error {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #dc2626;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider-text {
            font-size: 12px;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* footer note */
        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        /* validation error */
        .field-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 4px;
        }

        /* responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 40px 28px; }
        }
    </style>
</head>

<body>

    <!-- LEFT DECORATIVE PANEL -->
    <div class="left-panel">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="grid-overlay"></div>

        <div class="left-content">
            <div class="brand">
                <div class="brand-icon">🎪</div>
                <div class="brand-name">Book<span>Tix</span></div>
            </div>

            <h1 class="left-headline">
                Manage your<br>events with <em>ease</em>
            </h1>

            <p class="left-desc">
                A powerful admin panel to create, manage, and monitor all your events in one place.
            </p>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-dot">📅</div>
                    <span class="feature-text">Create and manage events effortlessly</span>
                </div>
                <div class="feature-item">
                    <div class="feature-dot">🎟️</div>
                    <span class="feature-text">Track registrations in real-time</span>
                </div>
                <div class="feature-item">
                    <div class="feature-dot">📊</div>
                    <span class="feature-text">Monitor quota and availability live</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT LOGIN PANEL -->
    <div class="right-panel">
        <div class="login-card">

            <div class="login-header">
                <div class="login-title">Welcome back 👋</div>
                <div class="login-subtitle">Sign in to your admin account to continue</div>
            </div>

            <!-- Session Errors -->
            @if ($errors->any())
            <div class="alert-error">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                </svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="admin@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword()" id="toggleBtn">
                            <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="form-extras">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                    </svg>
                    Sign in to Dashboard
                </button>

            </form>

            <div class="login-footer">
                Protected area · BookTix Admin Panel
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>
                    <path d="M1 12s4-8 11-8"/><circle cx="12" cy="12" r="3"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>

</body>
</html>