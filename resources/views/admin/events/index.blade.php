@extends('layouts.admin')

@section('title', 'Events')

@section('content')

<style>
    /* ── PAGE STYLES ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-header-left h2 {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -0.3px;
    }

    .page-header-left p {
        font-size: 13px;
        color: #6b7280;
        margin-top: 3px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #6366f1;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(99,102,241,0.3);
    }

    .btn-primary:hover {
        background: #4f46e5;
        box-shadow: 0 4px 16px rgba(99,102,241,0.4);
        transform: translateY(-1px);
    }

    /* Stats row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }

    .stat-icon.indigo { background: #eef2ff; }
    .stat-icon.green  { background: #f0fdf4; }
    .stat-icon.amber  { background: #fffbeb; }

    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    /* Table card */
    .table-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .table-toolbar {
        padding: 18px 22px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        min-width: 240px;
    }

    .search-box input {
        border: none;
        background: transparent;
        font-size: 13px;
        color: #374151;
        outline: none;
        width: 100%;
    }

    .search-box input::placeholder { color: #9ca3af; }

    table { width: 100%; border-collapse: collapse; }

    thead tr {
        background: #f9fafb;
    }

    th {
        padding: 11px 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6b7280;
        text-align: left;
        white-space: nowrap;
    }

    th:last-child { text-align: right; }

    td {
        padding: 14px 20px;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }

    tbody tr {
        transition: background 0.12s;
    }

    tbody tr:hover { background: #fafbff; }

    .event-title-cell {
        display: flex;
        flex-direction: column;
    }

    .event-name {
        font-weight: 500;
        color: #111827;
    }

    .event-date {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 2px;
    }

    .badge-quota {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-quota.available {
        background: #f0fdf4;
        color: #16a34a;
    }

    .badge-quota.full {
        background: #fff5f5;
        color: #dc2626;
    }

    .price-tag {
        font-weight: 500;
        color: #111827;
    }

    .action-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
    }

    .action-btn.edit {
        background: #eef2ff;
        color: #6366f1;
    }

    .action-btn.edit:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .action-btn.delete {
        background: #fff5f5;
        color: #ef4444;
    }

    .action-btn.delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .table-footer {
        padding: 16px 22px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-count {
        font-size: 13px;
        color: #6b7280;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 12px;
    }

    .empty-title {
        font-family: 'Syne', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .empty-desc {
        font-size: 13px;
        color: #9ca3af;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h2>All Events</h2>
        <p>Manage and monitor your event catalog</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Create Event
    </a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon indigo">📅</div>
        <div>
            <div class="stat-value">{{ $events->total() }}</div>
            <div class="stat-label">Total Events</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-value">{{ $events->where('available_quota', '>', 0)->count() }}</div>
            <div class="stat-label">Available</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">🔥</div>
        <div>
            <div class="stat-value">{{ $events->where('available_quota', 0)->count() }}</div>
            <div class="stat-label">Sold Out</div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="table-card">
    <div class="table-toolbar">
        <div class="search-box">
            <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Search events..." id="searchInput">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="eventsTable">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Quota</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td>
                        <div class="event-title-cell">
                            <span class="event-name">{{ $event->title }}</span>
                            @if($event->event_date)
                                <span class="event-date">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span style="display:flex;align-items:center;gap:5px;color:#6b7280;font-size:13px;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ $event->location }}
                        </span>
                    </td>
                    <td>
                        <span class="price-tag">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="badge-quota {{ $event->available_quota > 0 ? 'available' : 'full' }}">
                            {{ $event->available_quota > 0 ? '●' : '●' }}
                            {{ $event->available_quota > 0 ? $event->available_quota . ' left' : 'Full' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.events.edit', $event) }}" class="action-btn edit">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <div class="empty-title">No events yet</div>
                            <div class="empty-desc">Start by creating your first event</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span class="table-count">
            Showing {{ $events->firstItem() }}–{{ $events->lastItem() }} of {{ $events->total() }} events
        </span>
        {{ $events->links() }}
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#eventsTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

@endsection