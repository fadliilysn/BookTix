<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login — BookTix</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,700;1,400;1,700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:      #fafaf9;
            --surface: #ffffff;
            --border:  #e8e5e0;
            --text:    #1a1814;
            --text-2:  #4a4540;
            --text-3:  #9a9490;
            --accent:  #6366f1;
            --accent-dark: #4f46e5;
            --accent-soft: rgba(99,102,241,0.08);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 40px rgba(0,0,0,0.06);
            animation: fadeUp 0.4s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Brand */
        .brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            margin-bottom: 32px;
        }

        .brand-mark {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .brand-name {
            font-family: 'Fraunces', serif;
            font-size: 20px; font-weight: 700;
            color: var(--text);
        }

        .brand-name span { color: var(--accent); }

        /* Heading */
        .heading {
            font-family: 'Fraunces', serif;
            font-size: 26px; font-weight: 700;
            color: var(--text);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .subheading {
            font-size: 14px;
            color: var(--text-3);
            margin-bottom: 28px;
        }

        /* Form */
        .form-group { margin-bottom: 16px; }

        label {
            display: block;
            font-size: 13px; font-weight: 600;
            color: var(--text-2);
            margin-bottom: 7px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
            background: white;
        }

        input::placeholder { color: var(--text-3); }

        /* Password wrapper */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; color: var(--text-3);
            padding: 4px;
            transition: color 0.15s;
        }
        .pw-toggle:hover { color: var(--text-2); }

        /* Remember + forgot */
        .form-row {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .remember {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; color: var(--text-2); cursor: pointer;
        }

        .remember input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .forgot-link:hover { color: var(--accent-dark); }

        /* Error */
        .error-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: #e11d48;
            margin-bottom: 16px;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 3px 12px rgba(99,102,241,0.35);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .btn-submit:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
        }

        .btn-submit:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: var(--border);
        }

        .divider span {
            font-size: 12px; color: var(--text-3);
            white-space: nowrap;
        }

        /* Register link */
        .register-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-3);
        }

        .register-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s;
        }

        .register-link a:hover { color: var(--accent-dark); }

        /* Back to home */
        .back-home {
            display: flex; align-items: center; justify-content: center; gap: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: var(--text-3);
            text-decoration: none;
            transition: color 0.15s;
        }

        .back-home:hover { color: var(--text-2); }
    </style>
</head>
<body>

<div class="card">

    <!-- Brand -->
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-mark">🎟️</div>
        <div class="brand-name">Book<span>Tix</span></div>
    </a>

    <div class="heading">Selamat datang!</div>
    <div class="subheading">Masuk untuk mulai pesan tiket event favoritmu</div>

    <!-- Error -->
    @if($errors->any())
    <div class="error-box">
        {{ $errors->first() }}
    </div>
    @endif

    @if(session('status'))
    <div style="background:#ecfdf5;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;font-size:13px;color:#16a34a;margin-bottom:16px;">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="kamu@email.com"
                   autofocus required>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <div class="pw-wrap">
                <input type="password" id="password" name="password"
                       placeholder="••••••••" required>
                <button type="button" class="pw-toggle" onclick="togglePw()" tabindex="-1">
                    <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember + Forgot -->
        <div class="form-row">
            <label class="remember">
                <input type="checkbox" name="remember">
                Ingat saya
            </label>
            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
            </svg>
            Masuk
        </button>
    </form>

    <div class="divider"><span>atau</span></div>

    <div class="register-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>

    <a href="{{ url('/') }}" class="back-home">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali ke beranda
    </a>
</div>

<script>
    function togglePw() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        }
    }
</script>

</body>
</html>