@extends('layouts.user')

@section('title', $event->title)
@section('meta_description', Str::limit($event->description, 160))

@section('content')

<style>
    .container { max-width: 1200px; margin: 0 auto; padding: 40px 24px 60px; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--text-3);
        margin-bottom: 28px;
    }

    .breadcrumb a { color: var(--text-3); text-decoration: none; transition: color 0.15s; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb-sep { color: var(--border-2); }

    /* Layout */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 28px;
        align-items: start;
    }

    /* Event header card */
    .event-hero {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .event-banner {
        height: 240px;
        display: flex; align-items: center; justify-content: center;
        font-size: 80px;
        background: linear-gradient(135deg, #eef2ff, #ddd6fe);
        position: relative;
    }

    [data-theme="dark"] .event-banner {
        background: linear-gradient(135deg, #1e1b4b, #2e1065);
    }

    .event-status-badge {
        position: absolute;
        top: 16px; right: 16px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }

    .event-status-badge.available { background: #ecfdf5; color: #059669; }
    .event-status-badge.low       { background: #fffbeb; color: #d97706; }
    .event-status-badge.full      { background: #fff1f2; color: #e11d48; }

    [data-theme="dark"] .event-status-badge.available { background: #052e16; color: #4ade80; }
    [data-theme="dark"] .event-status-badge.low       { background: #451a03; color: #fbbf24; }
    [data-theme="dark"] .event-status-badge.full      { background: #2d0a0a; color: #f87171; }

    .event-hero-body { padding: 28px; }

    .event-title-main {
        font-family: 'Fraunces', serif;
        font-size: 30px; font-weight: 700;
        color: var(--text);
        letter-spacing: -0.5px;
        line-height: 1.2;
        margin-bottom: 16px;
    }

    /* Meta info row */
    .event-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 24px;
    }

    .meta-item {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
    }

    .meta-icon {
        width: 34px; height: 34px;
        border-radius: 8px;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .meta-label { font-size: 11px; color: var(--text-3); font-weight: 500; text-transform: uppercase; letter-spacing: 0.4px; }
    .meta-value { font-size: 13px; font-weight: 600; color: var(--text); margin-top: 2px; }

    /* Description */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }

    .card-icon {
        width: 28px; height: 28px; border-radius: 7px;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 15px; font-weight: 600; color: var(--text);
    }

    .card-body { padding: 22px; }

    .description-text {
        font-size: 15px;
        line-height: 1.75;
        color: var(--text-2);
        white-space: pre-line;
    }

    /* Quota bar */
    .quota-info {
        display: flex; justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .quota-label { font-size: 13px; color: var(--text-2); font-weight: 500; }
    .quota-count { font-size: 13px; font-weight: 700; color: var(--text); }

    .quota-bar {
        height: 8px;
        background: var(--border);
        border-radius: 4px;
        overflow: hidden;
    }

    .quota-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .quota-fill.good { background: linear-gradient(90deg, #10b981, #34d399); }
    .quota-fill.low  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .quota-fill.full { background: linear-gradient(90deg, #ef4444, #f87171); }

    /* ── BOOKING SIDEBAR ── */
    .booking-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        position: sticky;
        top: 80px;
    }

    .booking-header {
        padding: 22px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
    }

    .price-display {
        font-family: 'Fraunces', serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--text);
        line-height: 1;
    }

    .price-display.free { color: #059669; }
    .price-label { font-size: 13px; color: var(--text-3); margin-top: 4px; }

    .booking-body { padding: 22px; }

    /* Quantity picker */
    .quantity-section { margin-bottom: 20px; }
    .quantity-label {
        font-size: 13px; font-weight: 600;
        color: var(--text); margin-bottom: 10px;
        display: block;
    }

    .quantity-picker {
        display: flex; align-items: center;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        background: var(--bg);
    }

    .qty-btn {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 400;
        color: var(--text-2);
        background: transparent;
        border: none; cursor: pointer;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--border);
        color: var(--text);
    }

    .qty-btn:disabled { opacity: 0.3; cursor: not-allowed; }

    .qty-input {
        flex: 1;
        text-align: center;
        border: none;
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
        background: transparent;
        font-family: 'Fraunces', serif;
        font-size: 18px; font-weight: 700;
        color: var(--text);
        outline: none;
        padding: 10px;
        -moz-appearance: textfield;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

    /* Order summary */
    .order-summary {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .summary-row {
        display: flex; justify-content: space-between;
        font-size: 13px; color: var(--text-2);
        margin-bottom: 8px;
    }

    .summary-row:last-child {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 1px solid var(--border);
        font-size: 15px; font-weight: 700;
        color: var(--text);
    }

    /* Book button */
    .book-now-btn {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 14px;
        background: var(--accent);
        color: white;
        border-radius: 12px;
        font-size: 15px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 3px 12px rgba(99,102,241,0.35);
        text-decoration: none;
    }

    .book-now-btn:hover:not(:disabled) {
        background: var(--accent-dark);
        box-shadow: 0 6px 20px rgba(99,102,241,0.45);
        transform: translateY(-1px);
    }

    .book-now-btn:disabled {
        background: var(--border);
        color: var(--text-3);
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    /* Login prompt */
    .login-prompt {
        padding: 14px;
        background: var(--accent-soft);
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 12px;
        text-align: center;
    }

    .login-prompt p { font-size: 13px; color: var(--text-2); margin-bottom: 10px; }
    .login-prompt a {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 11px;
        background: var(--accent); color: white;
        border-radius: 10px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
    }

    .login-prompt a:hover { background: var(--accent-dark); }

    /* Trust indicators */
    .trust-items {
        display: flex; flex-direction: column; gap: 8px;
        margin-top: 18px;
    }

    .trust-item {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; color: var(--text-3);
    }

    @media (max-width: 900px) {
        .detail-layout { grid-template-columns: 1fr; }
        .booking-card { position: static; }
        .event-meta-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('events.index') }}">Events</a>
        <span class="breadcrumb-sep">›</span>
        <span>{{ Str::limit($event->title, 40) }}</span>
    </div>

    @php
        $quota    = $event->available_quota ?? 0;
        $total    = $event->quota ?? 0;
        $pct      = $total > 0 ? round(($total - $quota) / $total * 100) : 100;
        $qClass   = $quota === 0 ? 'full' : ($quota <= 10 ? 'low' : 'good');
        $qLabel   = $quota === 0 ? 'Sold Out' : ($quota <= 10 ? "Only $quota tickets left!" : "$quota tickets available");
        $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
    @endphp

    <div class="detail-layout">

        <!-- LEFT: Event Info -->
        <div>

            <!-- Hero -->
            <div class="event-hero">
                <div class="event-banner">
                    🎪
                    <span class="event-status-badge {{ $quota === 0 ? 'full' : ($quota <= 10 ? 'low' : 'available') }}">
                        {{ $qLabel }}
                    </span>
                </div>

                <div class="event-hero-body">
                    <h1 class="event-title-main">{{ $event->title }}</h1>

                    <div class="event-meta-grid">
                        @if($eventDate)
                        <div class="meta-item">
                            <div class="meta-icon">📅</div>
                            <div>
                                <div class="meta-label">Date & Time</div>
                                <div class="meta-value">{{ $eventDate->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        <div class="meta-item">
                            <div class="meta-icon">📍</div>
                            <div>
                                <div class="meta-label">Location</div>
                                <div class="meta-value">{{ $event->location }}</div>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">🎟️</div>
                            <div>
                                <div class="meta-label">Quota</div>
                                <div class="meta-value">{{ number_format($event->quota) }} tickets</div>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">💰</div>
                            <div>
                                <div class="meta-label">Price</div>
                                <div class="meta-value">
                                    @if($event->price == 0)
                                        FREE
                                    @else
                                        Rp {{ number_format($event->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quota bar -->
                    <div class="quota-info">
                        <span class="quota-label">Ticket availability</span>
                        <span class="quota-count">{{ $quota }} / {{ $total }} remaining</span>
                    </div>
                    <div class="quota-bar">
                        <div class="quota-fill {{ $qClass }}" style="width: {{ 100 - $pct }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($event->description)
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">📝</div>
                    <div class="card-title">About This Event</div>
                </div>
                <div class="card-body">
                    <div class="description-text">{{ $event->description }}</div>
                </div>
            </div>
            @endif

        </div>

        <!-- RIGHT: Booking -->
        <div>
            <div class="booking-card">

                <div class="booking-header">
                    @if($event->price == 0)
                        <div class="price-display free">FREE</div>
                        <div class="price-label">No payment required</div>
                    @else
                        <div class="price-display">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                        <div class="price-label">per ticket</div>
                    @endif
                </div>

                <div class="booking-body">
                    @if($quota > 0)

                        @auth
                        <form action="{{ route('orders.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <!-- Quantity -->
                            <div class="quantity-section">
                                <label class="quantity-label">Number of Tickets</label>
                                <div class="quantity-picker">
                                    <button type="button" class="qty-btn" id="decreaseBtn" onclick="changeQty(-1)" disabled>−</button>
                                    <input type="number" name="quantity" id="qtyInput"
                                           class="qty-input" value="1" min="1"
                                           max="{{ min($quota, 10) }}" readonly>
                                    <button type="button" class="qty-btn" id="increaseBtn" onclick="changeQty(1)">+</button>
                                </div>
                            </div>

                            <!-- Summary -->
                            @if($event->price > 0)
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Price per ticket</span>
                                    <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-row">
                                    <span>Quantity</span>
                                    <span id="summaryQty">1</span>
                                </div>
                                <div class="summary-row">
                                    <span>Total</span>
                                    <span id="summaryTotal">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endif

                            <button type="submit" class="book-now-btn" id="bookBtn">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                                </svg>
                                Book Now
                            </button>
                        </form>
                        @else
                        <!-- Guest: prompt login -->
                        <div class="login-prompt">
                            <p>Login to book tickets for this event</p>
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                                </svg>
                                Login to Book
                            </a>
                        </div>
                        @endauth

                    @else
                        <!-- Sold out -->
                        <button class="book-now-btn" disabled>Sold Out</button>
                    @endif

                    <!-- Trust indicators -->
                    <div class="trust-items">
                        <div class="trust-item">
                            <svg width="14" height="14" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Secure payment via Midtrans
                        </div>
                        <div class="trust-item">
                            <svg width="14" height="14" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Instant ticket delivery
                        </div>
                        <div class="trust-item">
                            <svg width="14" height="14" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Ticket sent to your email
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const price    = {{ $event->price }};
    const maxQty   = {{ min($quota, 10) }};
    let   qty      = 1;

    function changeQty(delta) {
        qty = Math.min(Math.max(1, qty + delta), maxQty);
        document.getElementById('qtyInput').value = qty;
        document.getElementById('decreaseBtn').disabled = qty <= 1;
        document.getElementById('increaseBtn').disabled = qty >= maxQty;

        // Update summary
        if (price > 0) {
            document.getElementById('summaryQty').textContent = qty;
            const total = price * qty;
            document.getElementById('summaryTotal').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }
    }
</script>

@endsection