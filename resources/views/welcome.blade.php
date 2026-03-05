@extends('layouts.user')

@section('title', 'BookTix')

@section('content')

<style>
    /* ── HERO ── */
    .hero {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 24px 60px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        background: var(--accent-soft);
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: var(--accent);
        letter-spacing: 0.3px;
        margin-bottom: 20px;
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(38px, 5vw, 58px);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -1.5px;
        color: var(--text);
        margin-bottom: 20px;
    }

    .hero-title em {
        font-style: italic;
        color: var(--accent);
    }

    .hero-desc {
        font-size: 16px;
        color: var(--text-2);
        line-height: 1.7;
        margin-bottom: 32px;
        max-width: 420px;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 24px;
        background: var(--accent);
        color: white;
        border-radius: 10px;
        font-size: 14px; font-weight: 600;
        text-decoration: none;
        border: none; cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(99,102,241,0.35);
        font-family: 'DM Sans', sans-serif;
    }

    .btn-primary:hover {
        background: var(--accent-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(99,102,241,0.45);
    }

    .btn-outline {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 24px;
        background: transparent;
        color: var(--text-2);
        border-radius: 10px;
        font-size: 14px; font-weight: 500;
        text-decoration: none;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-outline:hover {
        background: var(--bg-2);
        color: var(--text);
        border-color: var(--border-2);
    }

    .hero-stats {
        display: flex;
        gap: 32px;
        margin-top: 40px;
        padding-top: 32px;
        border-top: 1px solid var(--border);
    }

    .hero-stat-value {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 12px;
        color: var(--text-3);
        margin-top: 4px;
    }

    /* Hero visual */
    .hero-visual {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .ticket-preview {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-md);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: default;
        animation: floatIn 0.5s ease forwards;
        opacity: 0;
    }

    .ticket-preview:nth-child(1) { animation-delay: 0.1s; }
    .ticket-preview:nth-child(2) { animation-delay: 0.2s; transform: translateX(30px); }
    .ticket-preview:nth-child(3) { animation-delay: 0.3s; }

    @keyframes floatIn {
        to { opacity: 1; transform: translateX(0); }
    }

    .ticket-preview:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .ticket-emoji {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .ticket-info { flex: 1; min-width: 0; }
    .ticket-name { font-weight: 600; font-size: 14px; color: var(--text); }
    .ticket-meta { font-size: 12px; color: var(--text-3); margin-top: 3px; }

    .ticket-price {
        font-family: 'Fraunces', serif;
        font-size: 16px;
        font-weight: 700;
        color: var(--accent);
        flex-shrink: 0;
    }

    /* ── SEARCH BAR ── */
    .search-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px 60px;
    }

    .search-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 8px 8px 8px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow);
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .search-bar:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .search-icon { color: var(--text-3); flex-shrink: 0; }

    .search-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 15px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        outline: none;
        min-width: 0;
    }

    .search-input::placeholder { color: var(--text-3); }

    .search-btn {
        padding: 10px 24px;
        background: var(--accent);
        color: white;
        border-radius: 8px;
        font-size: 14px; font-weight: 600;
        border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .search-btn:hover { background: var(--accent-dark); }

    /* ── EVENTS SECTION ── */
    .events-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px 60px;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
    }

    .section-title {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.5px;
    }

    .section-sub {
        font-size: 14px;
        color: var(--text-3);
        margin-top: 4px;
    }

    .view-all {
        font-size: 13px;
        font-weight: 500;
        color: var(--accent);
        text-decoration: none;
        display: flex; align-items: center; gap: 4px;
        flex-shrink: 0;
        transition: gap 0.15s;
    }

    .view-all:hover { gap: 7px; }

    /* Event Cards Grid */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .event-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.2s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--border-2);
    }

    /* Event card thumbnail */
    .event-thumb {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        position: relative;
        overflow: hidden;
    }

    /* Different gradients for variety */
    .event-card:nth-child(4n+1) .event-thumb { background: linear-gradient(135deg, #eef2ff, #ddd6fe); }
    .event-card:nth-child(4n+2) .event-thumb { background: linear-gradient(135deg, #ecfdf5, #a7f3d0); }
    .event-card:nth-child(4n+3) .event-thumb { background: linear-gradient(135deg, #fff7ed, #fed7aa); }
    .event-card:nth-child(4n+0) .event-thumb { background: linear-gradient(135deg, #fdf2f8, #f9a8d4); }

    [data-theme="dark"] .event-card:nth-child(4n+1) .event-thumb { background: linear-gradient(135deg, #1e1b4b, #2e1065); }
    [data-theme="dark"] .event-card:nth-child(4n+2) .event-thumb { background: linear-gradient(135deg, #052e16, #064e3b); }
    [data-theme="dark"] .event-card:nth-child(4n+3) .event-thumb { background: linear-gradient(135deg, #431407, #7c2d12); }
    [data-theme="dark"] .event-card:nth-child(4n+0) .event-thumb { background: linear-gradient(135deg, #4a044e, #831843); }

    .event-quota-badge {
        position: absolute;
        top: 12px; right: 12px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
    }

    .event-quota-badge.available {
        background: rgba(16,185,129,0.15);
        color: #059669;
        border: 1px solid rgba(16,185,129,0.3);
    }

    .event-quota-badge.low {
        background: rgba(245,158,11,0.15);
        color: #d97706;
        border: 1px solid rgba(245,158,11,0.3);
    }

    .event-quota-badge.full {
        background: rgba(239,68,68,0.15);
        color: #dc2626;
        border: 1px solid rgba(239,68,68,0.3);
    }

    /* Event card body */
    .event-body {
        padding: 18px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .event-date-row {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--accent);
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .event-title {
        font-family: 'Fraunces', serif;
        font-size: 17px;
        font-weight: 600;
        color: var(--text);
        line-height: 1.35;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-location {
        font-size: 13px;
        color: var(--text-3);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 16px;
        flex: 1;
    }

    .event-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid var(--border);
    }

    .event-price {
        font-family: 'Fraunces', serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
    }

    .event-price.free {
        color: #059669;
    }

    .event-price-label {
        font-size: 11px;
        color: var(--text-3);
        font-weight: 400;
        margin-top: 1px;
    }

    .book-btn {
        padding: 7px 16px;
        background: var(--accent-soft);
        color: var(--accent);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }

    .book-btn:hover {
        background: var(--accent);
        color: white;
    }

    .book-btn.sold-out {
        background: var(--bg-2);
        color: var(--text-3);
        cursor: not-allowed;
    }

    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon { font-size: 48px; margin-bottom: 16px; }
    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 22px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 8px;
    }

    .empty-desc { font-size: 15px; color: var(--text-3); }

    /* ── CTA SECTION ── */
    .cta-section {
        background: var(--surface);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 80px 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 600px; height: 300px;
        background: radial-gradient(ellipse, rgba(99,102,241,0.07) 0%, transparent 70%);
        pointer-events: none;
    }

    .cta-title {
        font-family: 'Fraunces', serif;
        font-size: 36px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.8px;
        margin-bottom: 12px;
        position: relative;
    }

    .cta-desc {
        font-size: 16px;
        color: var(--text-2);
        margin-bottom: 28px;
        position: relative;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero {
            grid-template-columns: 1fr;
            padding: 40px 20px 40px;
            gap: 40px;
        }

        .hero-visual { display: none; }
        .events-grid { grid-template-columns: 1fr; }
        .hero-stats { gap: 20px; }
        .search-bar { flex-wrap: wrap; }
    }
</style>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            🎉 Discover Amazing Events
        </div>

        <h1 class="hero-title">
            Book your next<br>
            <em>unforgettable</em><br>
            experience
        </h1>

        <p class="hero-desc">
            Find and book tickets for the best events around you — concerts, workshops, conferences, and more. All in one place.
        </p>

        <div class="hero-actions">
            <a href="{{ route('events.index') }}" class="btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                Browse Events
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn-outline">
                Create Account →
            </a>
            @endguest
        </div>

        <div class="hero-stats">
            <div>
                <div class="hero-stat-value">{{ $totalEvents }}+</div>
                <div class="hero-stat-label">Events Available</div>
            </div>
            <div>
                <div class="hero-stat-value">{{ $totalTickets }}+</div>
                <div class="hero-stat-label">Tickets Sold</div>
            </div>
            <div>
                <div class="hero-stat-value">100%</div>
                <div class="hero-stat-label">Secure Booking</div>
            </div>
        </div>
    </div>

    <!-- Hero visual — ticket previews -->
    <!-- Hero visual — ticket previews dari database -->
    <div class="hero-visual">
        @php
            $emojis = ['🎵', '💻', '🎨', '🎪', '🎭', '🏆'];
            $colors = ['#eef2ff', '#ecfdf5', '#fff7ed', '#fdf2f8', '#eff6ff', '#fefce8'];
        @endphp

        @forelse($events->take(3) as $i => $event)
        <div class="ticket-preview">
            <div class="ticket-emoji" style="background:{{ $colors[$i % count($colors)] }};">
                {{ $emojis[$i % count($emojis)] }}
            </div>
            <div class="ticket-info">
                <div class="ticket-name">{{ Str::limit($event->title, 25) }}</div>
                <div class="ticket-meta">
                    📍 {{ $event->location }}
                    @if($event->event_date)
                        · {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    @endif
                </div>
            </div>
            <div class="ticket-price {{ $event->price == 0 ? 'style=color:#059669;' : '' }}">
                @if($event->price == 0)
                    <div class="ticket-price" style="color:#059669;">FREE</div>
                @else
                    <div class="ticket-price">Rp {{ number_format($event->price / 1000, 0) }}K</div>
                @endif
            </div>
        </div>
        @empty
        {{-- Fallback kalau belum ada event --}}
        <div class="ticket-preview">
            <div class="ticket-emoji" style="background:#eef2ff;">🎪</div>
            <div class="ticket-info">
                <div class="ticket-name">Belum ada event</div>
                <div class="ticket-meta">Tambahkan event di panel admin</div>
            </div>
            <div class="ticket-price">—</div>
        </div>
        @endforelse
    </div>
</section>

<!-- SEARCH -->
<section class="search-section">
    <form action="{{ route('events.index') }}" method="GET">
        <div class="search-bar">
            <svg class="search-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" class="search-input"
                   value="{{ request('search') }}"
                   placeholder="Search events by name or location...">
            <button type="submit" class="search-btn">Search</button>
        </div>
    </form>
</section>

<!-- EVENTS -->
<section class="events-section">
    <div class="section-header">
        <div>
            <div class="section-title">Upcoming Events</div>
            <div class="section-sub">{{ $events->total() }} events available to book</div>
        </div>
        <a href="{{ route('events.index') }}" class="view-all">
            View all
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="events-grid">
        @forelse($events as $event)
        @php
            $quota = $event->available_quota ?? 0;
            $quotaClass = $quota === 0 ? 'full' : ($quota <= 10 ? 'low' : 'available');
            $quotaLabel = $quota === 0 ? 'Sold Out' : ($quota <= 10 ? "Only $quota left" : "$quota available");
            $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
        @endphp
        <a href="{{ route('events.show', $event) }}" class="event-card">
            <div class="event-thumb">
                🎪
                <span class="event-quota-badge {{ $quotaClass }}">{{ $quotaLabel }}</span>
            </div>
            <div class="event-body">
                @if($eventDate)
                <div class="event-date-row">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>
                    {{ $eventDate->format('d M Y · H:i') }}
                </div>
                @endif

                <div class="event-title">{{ $event->title }}</div>

                <div class="event-location">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $event->location }}
                </div>

                <div class="event-footer">
                    <div>
                        @if($event->price == 0)
                            <div class="event-price free">FREE</div>
                        @else
                            <div class="event-price">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                            <div class="event-price-label">per ticket</div>
                        @endif
                    </div>

                    @if($quota > 0)
                        <span class="book-btn">Book Now</span>
                    @else
                        <span class="book-btn sold-out">Sold Out</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="empty-state">
            <div class="empty-icon">🎪</div>
            <div class="empty-title">No events yet</div>
            <div class="empty-desc">Check back soon for upcoming events!</div>
        </div>
        @endforelse
    </div>
</section>

<!-- CTA -->
@guest
<section class="cta-section">
    <h2 class="cta-title">Ready to book your next event?</h2>
    <p class="cta-desc">Create a free account and start booking tickets in minutes.</p>
    <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;">
        Get Started — It's Free
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
    </a>
</section>
@endguest

@endsection