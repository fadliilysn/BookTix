<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — BookTix</title>
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
            max-width: 440px;
            box-shadow: 0 4px 40px rgba(0,0,0,0.06);
            text-align: center;
            animation: fadeUp 0.4s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Brand */
        .brand {
            display: inline-flex; align-items: center; gap: 10px;
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

        /* Email icon */
        .email-icon {
            width: 72px; height: 72px;
            background: var(--accent-soft);
            border: 2px solid rgba(99,102,241,0.15);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 34px;
            margin: 0 auto 20px;
        }

        .heading {
            font-family: 'Fraunces', serif;
            font-size: 24px; font-weight: 700;
            color: var(--text);
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .description {
            font-size: 14px;
            color: var(--text-3);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .description strong {
            color: var(--text-2);
            font-weight: 600;
        }

        /* Success alert */
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #16a34a;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Steps */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 28px;
            text-align: left;
        }

        .step {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 12px 14px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .step-num {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text {
            font-size: 13px;
            color: var(--text-2);
            line-height: 1.5;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 3px 12px rgba(99,102,241,0.3);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
        }

        .btn-secondary {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: var(--text-3);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 13px; font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }

        .btn-secondary:hover {
            border-color: var(--text-3);
            color: var(--text-2);
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 16px 0;
        }

        .spam-note {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="card">

    <!-- Brand -->
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-mark">🎟️</div>
        <div class="brand-name">Book<span>Tix</span></div>
    </a>

    <!-- Icon -->
    <div class="email-icon">📧</div>

    <div class="heading">Cek email kamu!</div>
    <div class="description">
        Kami telah mengirim link verifikasi ke <strong>{{ auth()->user()->email }}</strong>.
        Klik link tersebut untuk mengaktifkan akun kamu.
    </div>

    <!-- Success: resend berhasil -->
    @if(session('status') == 'verification-link-sent')
    <div class="alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Link verifikasi baru telah dikirim ke email kamu!
    </div>
    @endif

    <!-- Steps -->
    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">Buka email di <strong>{{ auth()->user()->email }}</strong></div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">Cari email dari <strong>BookTix</strong> dengan subjek "Verify Email Address"</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">Klik tombol <strong>"Verify Email Address"</strong> di dalam email</div>
        </div>
    </div>

    <!-- Resend -->
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            Kirim Ulang Email Verifikasi
        </button>
    </form>

    <div class="divider"></div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
            </svg>
            Keluar & Gunakan Akun Lain
        </button>
    </form>

    <div class="spam-note">
        Tidak menerima email? Cek folder <strong>Spam</strong> atau klik "Kirim Ulang" di atas.
    </div>

</div>

</body>
</html>