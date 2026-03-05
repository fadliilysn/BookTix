<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Daftar — BookTix</title>
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

        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
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

        .form-group { margin-bottom: 14px; }

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

        .input-error {
            border-color: #f87171 !important;
        }

        .error-msg {
            font-size: 12px;
            color: #e11d48;
            margin-top: 5px;
        }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; color: var(--text-3);
            padding: 4px; transition: color 0.15s;
        }
        .pw-toggle:hover { color: var(--text-2); }

        /* Password strength */
        .pw-strength {
            margin-top: 8px;
            display: flex; gap: 4px;
        }

        .pw-strength-bar {
            flex: 1; height: 3px;
            border-radius: 2px;
            background: var(--border);
            transition: background 0.3s;
        }

        .pw-strength-bar.weak   { background: #f87171; }
        .pw-strength-bar.medium { background: #fbbf24; }
        .pw-strength-bar.strong { background: #34d399; }

        .pw-strength-label {
            font-size: 11px; color: var(--text-3);
            margin-top: 5px;
        }

        /* Benefit tags */
        .benefits {
            display: flex; flex-wrap: wrap; gap: 6px;
            margin-bottom: 20px;
        }

        .benefit-tag {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px;
            background: rgba(99,102,241,0.07);
            border-radius: 20px;
            font-size: 11px; font-weight: 500;
            color: var(--accent);
        }

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
            margin-top: 20px;
        }

        .btn-submit:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
        }

        .terms {
            font-size: 11.5px;
            color: var(--text-3);
            text-align: center;
            margin-top: 12px;
            line-height: 1.5;
        }

        .terms a { color: var(--accent); text-decoration: none; }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 18px 0;
        }

        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        .divider span { font-size: 12px; color: var(--text-3); }

        .login-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-3);
        }

        .login-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .back-home {
            display: flex; align-items: center; justify-content: center; gap: 5px;
            margin-top: 20px;
            font-size: 13px; color: var(--text-3);
            text-decoration: none; transition: color 0.15s;
        }

        .back-home:hover { color: var(--text-2); }
    </style>
</head>
<body>

<div class="card">

    <a href="{{ url('/') }}" class="brand">
        <div class="brand-mark">🎟️</div>
        <div class="brand-name">Book<span>Tix</span></div>
    </a>

    <div class="heading">Buat akun baru</div>
    <div class="subheading">Daftar gratis dan mulai pesan tiket event impianmu</div>

    <!-- Benefits -->
    <div class="benefits">
        <span class="benefit-tag">✨ Gratis</span>
        <span class="benefit-tag">🎟️ Tiket instan</span>
        <span class="benefit-tag">🔒 Aman & terpercaya</span>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   placeholder="Nama kamu"
                   class="{{ $errors->has('name') ? 'input-error' : '' }}"
                   autofocus required>
            @error('name')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="kamu@email.com"
                   class="{{ $errors->has('email') ? 'input-error' : '' }}"
                   required>
            @error('email')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <div class="pw-wrap">
                <input type="password" id="password" name="password"
                       placeholder="Min. 8 karakter"
                       class="{{ $errors->has('password') ? 'input-error' : '' }}"
                       oninput="checkStrength(this.value)"
                       required>
                <button type="button" class="pw-toggle" onclick="togglePw('password', 'eye1')" tabindex="-1">
                    <svg id="eye1" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            <!-- Strength indicator -->
            <div class="pw-strength" id="strengthBars">
                <div class="pw-strength-bar" id="bar1"></div>
                <div class="pw-strength-bar" id="bar2"></div>
                <div class="pw-strength-bar" id="bar3"></div>
                <div class="pw-strength-bar" id="bar4"></div>
            </div>
            <div class="pw-strength-label" id="strengthLabel"></div>
            @error('password')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="pw-wrap">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Ulangi password"
                       required>
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', 'eye2')" tabindex="-1">
                    <svg id="eye2" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8zM19 8v6M22 11h-6"/>
            </svg>
            Buat Akun
        </button>

        <div class="terms">
            Dengan mendaftar, kamu setuju dengan
            <a href="#">Syarat & Ketentuan</a> dan
            <a href="#">Kebijakan Privasi</a> BookTix.
        </div>
    </form>

    <div class="divider"><span>sudah punya akun?</span></div>

    <div class="login-link">
        <a href="{{ route('login') }}">Masuk sekarang →</a>
    </div>

    <a href="{{ url('/') }}" class="back-home">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali ke beranda
    </a>
</div>

<script>
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        }
    }

    function checkStrength(pw) {
        const bars  = [1,2,3,4].map(i => document.getElementById('bar' + i));
        const label = document.getElementById('strengthLabel');

        bars.forEach(b => b.className = 'pw-strength-bar');

        if (!pw) { label.textContent = ''; return; }

        let score = 0;
        if (pw.length >= 8)  score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;

        const levels = ['', 'weak', 'medium', 'medium', 'strong'];
        const labels = ['', 'Lemah', 'Cukup', 'Bagus', 'Kuat'];
        const colors = ['', '#f87171', '#fbbf24', '#fbbf24', '#34d399'];

        for (let i = 0; i < score; i++) {
            bars[i].classList.add(levels[score]);
        }

        label.textContent = labels[score];
        label.style.color = colors[score];
    }
</script>

</body>
</html>