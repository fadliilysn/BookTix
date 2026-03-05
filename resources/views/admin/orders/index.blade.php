@extends('layouts.admin')

@section('title', 'Orders')

@section('content')

<style>
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

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 14px 14px 0 0;
    }

    .stat-card.indigo::after { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .stat-card.amber::after  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.green::after  { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.rose::after   { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .stat-card.violet::after { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.06); }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .stat-icon.indigo { background: #eef2ff; }
    .stat-icon.amber  { background: #fffbeb; }
    .stat-icon.green  { background: #ecfdf5; }
    .stat-icon.rose   { background: #fff1f2; }
    .stat-icon.violet { background: #f5f3ff; }

    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        margin-top: 3px;
    }

    /* Table card */
    .table-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .table-toolbar {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        flex: 1;
        min-width: 200px;
        max-width: 300px;
    }

    .search-box input {
        border: none;
        background: transparent;
        font-size: 13px;
        color: #374151;
        outline: none;
        width: 100%;
        font-family: 'DM Sans', sans-serif;
    }

    .search-box input::placeholder { color: #9ca3af; }

    .filter-select {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        color: #374151;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        cursor: pointer;
    }

    .filter-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
        background: #6366f1;
        color: white;
    }

    .filter-btn:hover { background: #4f46e5; }

    table { width: 100%; border-collapse: collapse; }

    thead tr { background: #f9fafb; }

    th {
        padding: 11px 18px;
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6b7280;
        text-align: left;
        white-space: nowrap;
    }

    th:last-child { text-align: right; }

    td {
        padding: 13px 18px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody tr { transition: background 0.12s; }

    /* Order ID */
    .order-id {
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #6366f1;
    }

    /* User cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-ava {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .user-name-text { font-weight: 500; color: #111827; font-size: 13px; }
    .user-email-text { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }

    /* Status badge */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge.pending    { background: #fffbeb; color: #d97706; }
    .status-badge.paid       { background: #ecfdf5; color: #059669; }
    .status-badge.cancelled  { background: #fff1f2; color: #e11d48; }

    /* Payment badge */
    .pay-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        background: #f3f4f6;
        color: #374151;
    }

    .pay-badge.paid    { background: #ecfdf5; color: #059669; }
    .pay-badge.pending { background: #fffbeb; color: #d97706; }
    .pay-badge.none    { background: #f3f4f6; color: #9ca3af; }

    /* Price */
    .price-text {
        font-weight: 600;
        color: #111827;
        font-size: 13px;
    }

    /* Actions */
    .action-group {
        display: flex; align-items: center; justify-content: flex-end; gap: 6px;
    }

    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 11px;
        border-radius: 7px;
        font-size: 12px; font-weight: 500;
        text-decoration: none; border: none; cursor: pointer;
        transition: all 0.15s;
    }

    .action-btn.view { background: #eef2ff; color: #6366f1; }
    .action-btn.view:hover { background: #e0e7ff; }

    /* Table footer */
    .table-footer {
        padding: 14px 20px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-count { font-size: 13px; color: #6b7280; }

    /* Empty */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon  { font-size: 36px; margin-bottom: 10px; }
    .empty-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 600; color: #374151; }
    .empty-desc  { font-size: 13px; color: #9ca3af; margin-top: 4px; }

    /* items preview */
    .items-preview {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .item-line {
        font-size: 12px;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }

    .item-line strong { color: #374151; }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h2>Orders</h2>
        <p>Manage and monitor all customer orders</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card indigo">
        <div class="stat-icon indigo">🧾</div>
        <div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
    </div>
    <div class="stat-card amber">
        <div class="stat-icon amber">⏳</div>
        <div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-value">{{ $stats['paid'] }}</div>
            <div class="stat-label">Paid</div>
        </div>
    </div>
    <div class="stat-card rose">
        <div class="stat-icon rose">❌</div>
        <div>
            <div class="stat-value">{{ $stats['cancelled'] }}</div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>
    <div class="stat-card violet">
        <div class="stat-icon violet">💰</div>
        <div>
            <div class="stat-value">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="table-card">
    <div class="table-toolbar">
        <form method="GET" action="{{ route('admin.orders.index') }}"
              style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">

            <div class="search-box">
                <svg width="13" height="13" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name or email...">
            </div>

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="paid"      {{ request('status') == 'paid'      ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit" class="filter-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                Search
            </button>

            @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}"
               style="font-size:13px;color:#6b7280;text-decoration:none;display:flex;align-items:center;gap:4px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
                Clear
            </a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="user-ava">
                                {{ strtoupper(substr($order->user->name ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <div class="user-name-text">{{ $order->user->name ?? '-' }}</div>
                                <div class="user-email-text">{{ $order->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="items-preview">
                            @foreach($order->items->take(2) as $item)
                                <div class="item-line">
                                    <strong>{{ $item->quantity }}x</strong> {{ $item->event->title ?? 'Event deleted' }}
                                </div>
                            @endforeach
                            @if($order->items->count() > 2)
                                <div class="item-line" style="color:#6366f1;">
                                    +{{ $order->items->count() - 2 }} more
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="price-text">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @if($order->payment)
                            <span class="pay-badge {{ $order->payment->status === 'paid' ? 'paid' : 'pending' }}">
                                {{ ucfirst($order->payment->status) }}
                                · {{ $order->payment->payment_method }}
                            </span>
                        @else
                            <span class="pay-badge none">No payment</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $order->status }}">
                            @if($order->status === 'pending') ⏳
                            @elseif($order->status === 'paid') ✅
                            @else ❌
                            @endif
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280;white-space:nowrap;">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px;">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.orders.show', $order) }}" class="action-btn view">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">🧾</div>
                            <div class="empty-title">No orders found</div>
                            <div class="empty-desc">Orders will appear here once customers start purchasing</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="table-footer">
        <span class="table-count">
            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders
        </span>
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection