@extends('layouts.user')

@section('title', 'All Events — BookTix')

@section('content')

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 60px;
    }

    /* Page header */
    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }

    .page-sub {
        font-size: 15px;
        color: var(--text-3);
    }

    /* Search & Filter bar */
    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-wrap {
        flex: 1;
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-wrap:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .search-wrap input {
        border: none;
        background: transparent;
        font-size: 14px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        outline: none;
        width: 100%;
    }

    .search-wrap input::placeholder { color: var(--text-3); }

    .filter-select {
        padding: 10px 14px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
    }

    .filter-select:focus { border-color: var(--accent); }

    .filter-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px;
        background: var(--accent);
        color: white;
        border-radius: 10px;
        font-size: 14px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        transition: all 0.15s;
    }

    .filter-btn:hover { background: var(--accent-dark); }

    .clear-link {
        font-size: 13px;
        color: var(--text-3);
        text-decoration: none;
        display: flex; align-items: center; gap: 4px;
        transition: color 0.15s;
        white-space: nowrap;
    }

    .clear-link:hover { color: var(--text-2); }

    /* Results count */
    .results-info {
        font-size: 13px;
        color: var(--text-3);
        margin-bottom: 20px;
    }

    .results-info strong { color: var(--text); }

    /* Events grid */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
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
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--border-2);
    }

    .event-thumb {
        height: 150px;
        display: flex; align-items: center; justify-content: center;
        font-size: 48px;
        position: relative;
        overflow: hidden;
    }

    .event-card:nth-child(4n+1) .event-thumb { background: linear-gradient(135deg, #eef2ff, #ddd6fe); }
    .event-card:nth-child(4n+2) .event-thumb { background: linear-gradient(135deg, #ecfdf5, #a7f3d0); }
    .event-card:nth-child(4n+3) .event-thumb { background: linear-gradient(135deg, #fff7ed, #fed7aa); }
    .event-card:nth-child(4n+0) .event-thumb { background: linear-gradient(135deg, #fdf2f8, #f9a8d4); }

    [data-theme="dark"] .event-card:nth-child(4n+1) .event-thumb { background: linear-gradient(135deg, #1e1b4b, #2e1065); }
    [data-theme="dark"] .event-card:nth-child(4n+2) .event-thumb { background: linear-gradient(135deg, #052e16, #064e3b); }
    [data-theme="dark"] .event-card:nth-child(4n+3) .event-thumb { background: linear-gradient(135deg, #431407, #7c2d12); }
    [data-theme="dark"] .event-card:nth-child(4n+0) .event-thumb { background: linear-gradient(135deg, #4a044e, #831843); }

    .quota-badge {
        position: absolute;
        top: 10px; right: 10px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
    }

    .quota-badge.available { background: rgba(16,185,129,0.15); color: #059669; border: 1px solid rgba(16,185,129,0.3); }
    .quota-badge.low       { background: rgba(245,158,11,0.15); color: #d97706; border: 1px solid rgba(245,158,11,0.3); }
    .quota-badge.full      { background: rgba(239,68,68,0.15); color: #dc2626; border: 1px solid rgba(239,68,68,0.3); }

    .event-body {
        padding: 18px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .event-date-row {
        display: flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 600;
        color: var(--accent);
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .event-title {
        font-family: 'Fraunces', serif;
        font-size: 16px; font-weight: 600;
        color: var(--text);
        line-height: 1.35;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-location {
        font-size: 13px; color: var(--text-3);
        display: flex; align-items: center; gap: 4px;
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
        font-size: 18px; font-weight: 700;
        color: var(--text);
    }

    .event-price.free { color: #059669; }
    .event-price-label { font-size: 11px; color: var(--text-3); margin-top: 1px; }

    .book-btn {
        padding: 7px 16px;
        background: var(--accent-soft);
        color: var(--accent);
        border-radius: 8px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }

    .book-btn:hover { background: var(--accent); color: white; }
    .book-btn.sold-out { background: var(--bg-2); color: var(--text-3); cursor: not-allowed; }

    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon  { font-size: 52px; margin-bottom: 16px; }
    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 22px; font-weight: 600;
        color: var(--text); margin-bottom: 8px;
    }
    .empty-desc { font-size: 15px; color: var(--text-3); margin-bottom: 20px; }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        justify-content: center;
    }

    .pagination-wrap nav { display: flex; align-items: center; gap: 4px; }

    @media (max-width: 640px) {
        .events-grid { grid-template-columns: 1fr; }
        .filter-bar  { flex-direction: column; align-items: stretch; }
        .filter-btn  { justify-content: center; }
    }
</style>

<div class="container">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">All Events</div>
        <div class="page-sub">Find events you'll love and book your tickets instantly</div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('events.index') }}">
        <div class="filter-bar">
            <div class="search-wrap">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-3);flex-shrink:0;">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Search event name or location...">
            </div>

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="full"      {{ request('status') === 'full'      ? 'selected' : '' }}>Sold Out</option>
            </select>

            <button type="submit" class="filter-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                Search
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('events.index') }}" class="clear-link">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                    Clear
                </a>
            @endif
        </div>
    </form>

    <!-- Results info -->
    <div class="results-info">
        Showing <strong>{{ $events->total() }}</strong> event{{ $events->total() !== 1 ? 's' : '' }}
        @if(request('search'))
            for "<strong>{{ request('search') }}</strong>"
        @endif
    </div>

    <!-- Events Grid -->
    <div class="events-grid">
        @forelse($events as $event)
        @php
            $quota      = $event->available_quota ?? 0;
            $quotaClass = $quota === 0 ? 'full' : ($quota <= 10 ? 'low' : 'available');
            $quotaLabel = $quota === 0 ? 'Sold Out' : ($quota <= 10 ? "Only $quota left" : "$quota available");
            $eventDate  = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
        @endphp
        <a href="{{ route('events.show', $event) }}" class="event-card">
            <div class="event-thumb">
                🎪
                <span class="quota-badge {{ $quotaClass }}">{{ $quotaLabel }}</span>
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
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
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
            <div class="empty-icon">🔍</div>
            <div class="empty-title">No events found</div>
            <div class="empty-desc">
                @if(request('search'))
                    No events match "{{ request('search') }}". Try a different keyword.
                @else
                    There are no events available right now. Check back soon!
                @endif
            </div>
            @if(request('search') || request('status'))
                <a href="{{ route('events.index') }}" class="filter-btn" style="display:inline-flex;">
                    View All Events
                </a>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
    <div class="pagination-wrap">
        {{ $events->links() }}
    </div>
    @endif

</div>

@endsection