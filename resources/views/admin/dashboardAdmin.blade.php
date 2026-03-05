@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>
    /* ── WELCOME BANNER ── */
    .welcome-banner {
        background: linear-gradient(135deg, #0f1117 0%, #1e1b4b 60%, #312e81 100%);
        border-radius: 18px;
        padding: 28px 32px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        position: relative;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 160px; height: 160px;
        background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-text {
        position: relative;
        z-index: 1;
    }

    .welcome-greeting {
        font-size: 13px;
        color: #a5b4fc;
        font-weight: 500;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }

    .welcome-title {
        font-family: 'Syne', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }

    .welcome-subtitle {
        font-size: 13px;
        color: #818cf8;
        margin-top: 8px;
    }

    .welcome-actions {
        display: flex;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #6366f1;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(99,102,241,0.4);
    }

    .btn-primary:hover {
        background: #4f46e5;
        box-shadow: 0 4px 20px rgba(99,102,241,0.5);
        transform: translateY(-1px);
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.08);
        color: #c7d2fe;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.12);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-ghost:hover {
        background: rgba(255,255,255,0.13);
        color: white;
    }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px 22px;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.07);
        transform: translateY(-2px);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 14px 14px 0 0;
    }

    .stat-card.indigo::after { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .stat-card.green::after  { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.amber::after  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.rose::after   { background: linear-gradient(90deg, #f43f5e, #fb7185); }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .stat-icon-wrap {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
    }

    .stat-icon-wrap.indigo { background: #eef2ff; }
    .stat-icon-wrap.green  { background: #ecfdf5; }
    .stat-icon-wrap.amber  { background: #fffbeb; }
    .stat-icon-wrap.rose   { background: #fff1f2; }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .stat-trend.up   { background: #ecfdf5; color: #059669; }
    .stat-trend.down { background: #fff1f2; color: #e11d48; }
    .stat-trend.flat { background: #f3f4f6; color: #6b7280; }

    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        margin-top: 5px;
    }

    /* ── MAIN GRID ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
    }

    /* ── CARD ── */
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #eef2ff;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
    }

    .card-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .card-subtitle {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 1px;
    }

    .view-all-link {
        font-size: 12px;
        color: #6366f1;
        font-weight: 500;
        text-decoration: none;
        display: flex; align-items: center; gap: 3px;
        transition: gap 0.15s;
    }

    .view-all-link:hover { gap: 6px; }

    /* ── RECENT EVENTS TABLE ── */
    .event-table { width: 100%; border-collapse: collapse; }

    .event-table th {
        padding: 10px 20px;
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6b7280;
        background: #f9fafb;
        text-align: left;
    }

    .event-table th:last-child { text-align: right; }

    .event-table td {
        padding: 13px 20px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .event-table tr:last-child td { border-bottom: none; }
    .event-table tbody tr:hover { background: #fafbff; }

    .event-name-cell { font-weight: 500; color: #111827; }
    .event-loc { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge.upcoming  { background: #eff6ff; color: #2563eb; }
    .status-badge.ongoing   { background: #ecfdf5; color: #059669; }
    .status-badge.full      { background: #fff1f2; color: #e11d48; }
    .status-badge.past      { background: #f3f4f6; color: #6b7280; }

    .quota-bar-wrap {
        display: flex; align-items: center; gap: 8px;
    }

    .quota-bar {
        flex: 1;
        height: 5px;
        background: #f3f4f6;
        border-radius: 20px;
        overflow: hidden;
        min-width: 60px;
    }

    .quota-bar-fill {
        height: 100%;
        border-radius: 20px;
        transition: width 0.5s ease;
    }

    .quota-bar-fill.low  { background: #10b981; }
    .quota-bar-fill.mid  { background: #f59e0b; }
    .quota-bar-fill.high { background: #ef4444; }

    .quota-pct { font-size: 11px; color: #6b7280; white-space: nowrap; }

    .action-btn-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        background: #eef2ff;
        color: #6366f1;
    }

    .action-btn-sm:hover { background: #e0e7ff; }

    /* ── SIDEBAR CARDS ── */
    .sidebar-stack { display: flex; flex-direction: column; gap: 20px; }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 18px;
    }

    .qa-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 10px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #f3f4f6;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s;
        text-align: center;
    }

    .qa-btn:hover {
        background: #eef2ff;
        border-color: #e0e7ff;
        color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.12);
    }

    .qa-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .qa-label {
        font-size: 12px;
        font-weight: 500;
        line-height: 1.3;
    }

    /* Activity feed */
    .activity-feed { padding: 6px 0; }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 20px;
        transition: background 0.12s;
    }

    .activity-item:hover { background: #fafbff; }

    .activity-dot {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .activity-dot.register { background: #ecfdf5; }
    .activity-dot.create   { background: #eef2ff; }
    .activity-dot.delete   { background: #fff1f2; }
    .activity-dot.update   { background: #fffbeb; }

    .activity-content { flex: 1; min-width: 0; }
    .activity-text { font-size: 13px; color: #374151; line-height: 1.4; }
    .activity-text strong { color: #111827; font-weight: 500; }
    .activity-time { font-size: 11px; color: #9ca3af; margin-top: 3px; }

    /* ── UPCOMING EVENTS MINI ── */
    .upcoming-list { padding: 6px 0; }

    .upcoming-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        transition: background 0.12s;
        text-decoration: none;
    }

    .upcoming-item:hover { background: #fafbff; }

    .upcoming-date-box {
        width: 42px; height: 42px;
        border-radius: 10px;
        background: #eef2ff;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        flex-shrink: 0;
        text-align: center;
    }

    .upcoming-day {
        font-family: 'Syne', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: #6366f1;
        line-height: 1;
    }

    .upcoming-mon {
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        color: #818cf8;
        letter-spacing: 0.5px;
    }

    .upcoming-name {
        font-size: 13px;
        font-weight: 500;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .upcoming-loc {
        font-size: 11.5px;
        color: #9ca3af;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-empty {
        padding: 36px 20px;
        text-align: center;
    }

    .card-empty-icon { font-size: 32px; margin-bottom: 8px; }
    .card-empty-text { font-size: 13px; color: #9ca3af; }
</style>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-text">
        <div class="welcome-greeting">👋 Good day,</div>
        <div class="welcome-title">Welcome back, {{ auth()->user()->name }}!</div>
        <div class="welcome-subtitle">Here's what's happening with your events today.</div>
    </div>
    <div class="welcome-actions">
        <a href="{{ route('admin.events.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            New Event
        </a>
        <a href="{{ route('admin.events.index') }}" class="btn-ghost">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>
            </svg>
            Manage Events
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card indigo">
        <div class="stat-top">
            <div class="stat-icon-wrap indigo">📅</div>
            <span class="stat-trend up">↑ +3</span>
        </div>
        <div class="stat-value">{{ $totalEvents ?? $events->total() }}</div>
        <div class="stat-label">Total Events</div>
    </div>

    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-icon-wrap green">🎟️</div>
            <span class="stat-trend up">↑ +12</span>
        </div>
        <div class="stat-value">{{ $totalRegistrations ?? 0 }}</div>
        <div class="stat-label">Total Registrations</div>
    </div>

    <div class="stat-card amber">
        <div class="stat-top">
            <div class="stat-icon-wrap amber">⏳</div>
            <span class="stat-trend flat">— same</span>
        </div>
        <div class="stat-value">{{ $upcomingEvents ?? $events->filter(fn($e) => isset($e->event_date) && \Carbon\Carbon::parse($e->event_date)->isFuture())->count() }}</div>
        <div class="stat-label">Upcoming Events</div>
    </div>

    <div class="stat-card rose">
        <div class="stat-top">
            <div class="stat-icon-wrap rose">🔥</div>
            <span class="stat-trend down">↓ -1</span>
        </div>
        <div class="stat-value">{{ $soldOutEvents ?? $events->where('available_quota', 0)->count() }}</div>
        <div class="stat-label">Sold Out</div>
    </div>
</div>

<!-- Main Grid -->
<div class="main-grid">

    <!-- Left: Recent Events + Upcoming -->
    <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Recent Events Table -->
        <div class="card">
            <div class="card-header">
                <div class="card-title-group">
                    <div class="card-icon">📋</div>
                    <div>
                        <div class="card-title">Recent Events</div>
                        <div class="card-subtitle">Latest 5 events in the system</div>
                    </div>
                </div>
                <a href="{{ route('admin.events.index') }}" class="view-all-link">
                    View all
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @php
                $recentEvents = $events->take(5);
                $now = \Carbon\Carbon::now();
            @endphp

            @if($recentEvents->isEmpty())
                <div class="card-empty">
                    <div class="card-empty-icon">📭</div>
                    <div class="card-empty-text">No events yet. Create your first one!</div>
                </div>
            @else
            <div style="overflow-x:auto;">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Quota</th>
                            <th>Status</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEvents as $event)
                        @php
                            $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
                            $quota = $event->quota > 0 ? $event->quota : 1;
                            $available = $event->available_quota ?? $quota;
                            $filled = $quota - $available;
                            $pct = round(($filled / $quota) * 100);
                            $barClass = $pct >= 90 ? 'high' : ($pct >= 60 ? 'mid' : 'low');

                            if ($available == 0) {
                                $statusClass = 'full'; $statusLabel = 'Sold Out';
                            } elseif (!$eventDate) {
                                $statusClass = 'upcoming'; $statusLabel = 'Upcoming';
                            } elseif ($eventDate->isPast()) {
                                $statusClass = 'past'; $statusLabel = 'Past';
                            } elseif ($eventDate->isToday()) {
                                $statusClass = 'ongoing'; $statusLabel = 'Ongoing';
                            } else {
                                $statusClass = 'upcoming'; $statusLabel = 'Upcoming';
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="event-name-cell">{{ $event->title }}</div>
                                <div class="event-loc">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </td>
                            <td>
                                @if($eventDate)
                                    <span style="font-weight:500;color:#111827;">{{ $eventDate->format('d M Y') }}</span><br>
                                    <span style="font-size:11.5px;color:#9ca3af;">{{ $eventDate->format('H:i') }}</span>
                                @else
                                    <span style="color:#9ca3af;">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="quota-bar-wrap">
                                    <div class="quota-bar">
                                        <div class="quota-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="quota-pct">{{ $available }}/{{ $quota }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <a href="{{ route('admin.events.edit', $event) }}" class="action-btn-sm">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>

    <!-- Right Sidebar -->
    <div class="sidebar-stack">

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <div class="card-title-group">
                    <div class="card-icon">⚡</div>
                    <div>
                        <div class="card-title">Quick Actions</div>
                    </div>
                </div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.events.create') }}" class="qa-btn">
                    <div class="qa-icon">➕</div>
                    <span class="qa-label">New Event</span>
                </a>
                <a href="{{ route('admin.events.index') }}" class="qa-btn">
                    <div class="qa-icon">📋</div>
                    <span class="qa-label">All Events</span>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon">👥</div>
                    <span class="qa-label">Registrations</span>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon">📊</div>
                    <span class="qa-label">Reports</span>
                </a>
            </div>
        </div>

        <!-- Upcoming Events Mini -->
        <div class="card">
            <div class="card-header">
                <div class="card-title-group">
                    <div class="card-icon">🗓️</div>
                    <div>
                        <div class="card-title">Upcoming Events</div>
                        <div class="card-subtitle">Next scheduled events</div>
                    </div>
                </div>
            </div>

            @php
                $upcomingList = $events
                    ->filter(fn($e) => $e->event_date && \Carbon\Carbon::parse($e->event_date)->isFuture())
                    ->sortBy('event_date')
                    ->take(4);
            @endphp

            @if($upcomingList->isEmpty())
                <div class="card-empty">
                    <div class="card-empty-icon">🗓️</div>
                    <div class="card-empty-text">No upcoming events</div>
                </div>
            @else
                <div class="upcoming-list">
                    @foreach($upcomingList as $event)
                    @php $eDate = \Carbon\Carbon::parse($event->event_date); @endphp
                    <a href="{{ route('admin.events.edit', $event) }}" class="upcoming-item">
                        <div class="upcoming-date-box">
                            <div class="upcoming-day">{{ $eDate->format('d') }}</div>
                            <div class="upcoming-mon">{{ $eDate->format('M') }}</div>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="upcoming-name">{{ $event->title }}</div>
                            <div class="upcoming-loc">
                                <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </div>
                        </div>
                        <div style="font-size:11px;color:#d1d5db;flex-shrink:0;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <div class="card-title-group">
                    <div class="card-icon">🔔</div>
                    <div>
                        <div class="card-title">Recent Activity</div>
                        <div class="card-subtitle">Latest system activity</div>
                    </div>
                </div>
            </div>
            <div class="activity-feed">
                @php
                    $latestEvents = $events->sortByDesc('created_at')->take(4);
                @endphp

                @forelse($latestEvents as $event)
                <div class="activity-item">
                    <div class="activity-dot create">✨</div>
                    <div class="activity-content">
                        <div class="activity-text">
                            Event <strong>{{ \Illuminate\Support\Str::limit($event->title, 30) }}</strong> was created
                        </div>
                        <div class="activity-time">
                            {{ $event->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="card-empty">
                    <div class="card-empty-icon">🔔</div>
                    <div class="card-empty-text">No activity yet</div>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection