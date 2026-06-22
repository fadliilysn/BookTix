@extends('layouts.admin')

@section('title', 'Order Detail')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .back-btn {
        display: flex; align-items: center; justify-content: center;
        width: 38px; height: 38px;
        background: white; border: 1px solid #e5e7eb;
        border-radius: 10px; color: #6b7280;
        text-decoration: none; transition: all 0.15s; flex-shrink: 0;
    }

    .back-btn:hover { background: #f9fafb; color: #374151; }

    .page-title-text {
        font-family: 'Syne', sans-serif;
        font-size: 22px; font-weight: 700;
        color: #111827; letter-spacing: -0.3px;
    }

    .page-sub { font-size: 13px; color: #6b7280; margin-top: 3px; }

    .order-id-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px;
        background: #eef2ff; border: 1px solid #c7d2fe;
        border-radius: 20px; font-size: 12px;
        color: #6366f1; font-weight: 600;
    }

    /* Layout */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }

    /* Card */
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card:last-child { margin-bottom: 0; }

    .card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; gap: 10px;
    }

    .card-icon {
        width: 30px; height: 30px; border-radius: 8px;
        background: #eef2ff;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
    }

    .card-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px; font-weight: 700; color: #111827;
    }

    .card-body { padding: 20px 22px; }

    /* Info grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .info-item {}
    .info-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; margin-bottom: 5px; }
    .info-value { font-size: 14px; color: #111827; font-weight: 500; }
    .info-value.muted { color: #6b7280; font-weight: 400; }

    /* User card */
    .user-profile {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 22px;
    }

    .user-avatar-lg {
        width: 48px; height: 48px; border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-size: 16px;
        font-weight: 700; color: white; flex-shrink: 0;
    }

    .user-detail-name { font-size: 15px; font-weight: 600; color: #111827; }
    .user-detail-email { font-size: 13px; color: #6b7280; margin-top: 2px; }
    .user-detail-role {
        display: inline-flex; align-items: center;
        margin-top: 5px; padding: 2px 8px;
        background: #f3f4f6; border-radius: 10px;
        font-size: 11px; color: #6b7280; font-weight: 500;
    }

    /* Items table */
    .items-table { width: 100%; border-collapse: collapse; }

    .items-table th {
        padding: 10px 20px;
        font-size: 10.5px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.7px;
        color: #6b7280; background: #f9fafb;
        text-align: left;
    }

    .items-table th:last-child { text-align: right; }

    .items-table td {
        padding: 14px 20px;
        font-size: 13px; color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .items-table tr:last-child td { border-bottom: none; }

    .event-title-item { font-weight: 500; color: #111827; }
    .event-date-item  { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

    .subtotal { font-weight: 600; color: #111827; }

    /* Total row */
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 22px;
        border-top: 2px solid #f3f4f6;
        background: #fafbff;
    }

    .total-label { font-size: 14px; font-weight: 600; color: #374151; }
    .total-value {
        font-family: 'Syne', sans-serif;
        font-size: 20px; font-weight: 700; color: #111827;
    }

    /* Status badges */
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }

    .status-badge.pending   { background: #fffbeb; color: #d97706; }
    .status-badge.paid      { background: #ecfdf5; color: #059669; }
    .status-badge.cancelled { background: #fff1f2; color: #e11d48; }

    /* Sidebar */
    .sidebar-card {
        background: white; border: 1px solid #e5e7eb;
        border-radius: 16px; overflow: hidden;
        margin-bottom: 16px;
    }

    .sidebar-card:last-child { margin-bottom: 0; }

    /* Status update form */
    .status-form { padding: 18px; display: flex; flex-direction: column; gap: 10px; }

    .status-option {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 10px;
        border: 1.5px solid #e5e7eb; cursor: pointer;
        transition: all 0.15s;
    }

    .status-option:has(input:checked) {
        border-color: #6366f1;
        background: #eef2ff;
    }

    .status-option input[type="radio"] {
        accent-color: #6366f1;
        width: 15px; height: 15px;
        cursor: pointer;
    }

    .status-option-label {
        display: flex; flex-direction: column; gap: 1px;
    }

    .status-option-name { font-size: 13px; font-weight: 500; color: #111827; }
    .status-option-desc { font-size: 11px; color: #9ca3af; }

    .update-btn {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 7px;
        padding: 11px; border-radius: 10px;
        background: #6366f1; color: white;
        font-size: 13px; font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(99,102,241,0.3);
    }

    .update-btn:hover {
        background: #4f46e5;
        box-shadow: 0 4px 14px rgba(99,102,241,0.4);
    }

    /* Tickets */
    .ticket-list { padding: 6px 0; }

    .ticket-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 18px;
        border-bottom: 1px solid #f9fafb;
        transition: background 0.12s;
    }

    .ticket-item:last-child { border-bottom: none; }
    .ticket-item:hover { background: #fafbff; }

    .ticket-code-box {
        font-family: 'Courier New', monospace;
        font-size: 12px; font-weight: 600;
        color: #6366f1;
        background: #eef2ff;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 1px;
        flex: 1;
    }

    .ticket-event-name {
        font-size: 12px; color: #6b7280;
        white-space: nowrap; overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    /* Payment info */
    .payment-grid {
        padding: 18px;
        display: flex; flex-direction: column; gap: 12px;
    }

    .pay-row {
        display: flex; justify-content: space-between; align-items: center;
    }

    .pay-key { font-size: 12px; color: #6b7280; }
    .pay-val { font-size: 13px; font-weight: 500; color: #111827; }

    .divider-line {
        height: 1px; background: #f3f4f6;
    }

    /* Flash */
    .flash {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        font-size: 13px; margin-bottom: 20px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
</style>

<!-- Header -->
<div class="page-header">
    <a href="{{ route('admin.orders.index') }}" class="back-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
    </a>
    <div>
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="page-title-text">Order Detail</div>
            <span class="order-id-badge">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            <span class="status-badge {{ $order->status }}">
                @if($order->status === 'pending') ⏳
                @elseif($order->status === 'paid') ✅
                @else ❌
                @endif
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="page-sub">Placed on {{ $order->created_at->format('d F Y, H:i') }}</div>
    </div>
</div>

@if(session('success'))
<div class="flash flash-success">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="detail-layout">

    <!-- LEFT: Main content -->
    <div>

        <!-- Customer Info -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">👤</div>
                <div class="card-title">Customer</div>
            </div>
            <div class="user-profile">
                <div class="user-avatar-lg">
                    {{ strtoupper(substr($order->user->name ?? '?', 0, 2)) }}
                </div>
                <div>
                    <div class="user-detail-name">{{ $order->user->name ?? 'Unknown User' }}</div>
                    <div class="user-detail-email">{{ $order->user->email ?? '-' }}</div>
                    <span class="user-detail-role">{{ ucfirst($order->user->role ?? 'user') }}</span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">🎟️</div>
                <div class="card-title">Order Items</div>
            </div>

            <div style="overflow-x:auto;">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="event-title-item">{{ $item->event->title ?? 'Event deleted' }}</div>
                                @if($item->event && $item->event->event_date)
                                    <div class="event-date-item">
                                        📅 {{ \Carbon\Carbon::parse($item->event->event_date)->format('d M Y, H:i') }}
                                    </div>
                                @endif
                                @if($item->event && $item->event->location)
                                    <div class="event-date-item">
                                        📍 {{ $item->event->location }}
                                    </div>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align:right;">
                                <span class="subtotal">
                                    Rp {{ number_format($item->subtotal * $item->quantity, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-row">
                <span class="total-label">Total Amount</span>
                <span class="total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tickets -->
        @if($order->tickets->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <div class="card-icon">🎫</div>
                <div class="card-title">Generated Tickets ({{ $order->tickets->count() }})</div>
            </div>
            <div class="ticket-list">
                @foreach($order->tickets as $ticket)
                <div class="ticket-item">
                    <div class="ticket-code-box">{{ $ticket->ticket_code }}</div>
                    <div class="ticket-event-name">{{ $ticket->event->title ?? '-' }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- RIGHT: Sidebar -->
    <div>

        <!-- Update Status -->
        <div class="sidebar-card">
            <div class="card-header">
                <div class="card-icon">🔄</div>
                <div class="card-title">Update Status</div>
            </div>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="status-form">
                    <label class="status-option">
                        <input type="radio" name="status" value="pending"
                               {{ $order->status === 'pending' ? 'checked' : '' }}>
                        <div class="status-option-label">
                            <span class="status-option-name">⏳ Pending</span>
                            <span class="status-option-desc">Awaiting payment</span>
                        </div>
                    </label>
                    <label class="status-option">
                        <input type="radio" name="status" value="paid"
                               {{ $order->status === 'paid' ? 'checked' : '' }}>
                        <div class="status-option-label">
                            <span class="status-option-name">✅ Paid</span>
                            <span class="status-option-desc">Payment confirmed</span>
                        </div>
                    </label>
                    <label class="status-option">
                        <input type="radio" name="status" value="cancelled"
                               {{ $order->status === 'cancelled' ? 'checked' : '' }}>
                        <div class="status-option-label">
                            <span class="status-option-name">❌ Cancelled</span>
                            <span class="status-option-desc">Order cancelled</span>
                        </div>
                    </label>

                    <button type="submit" class="update-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Payment Info -->
        <div class="sidebar-card">
            <div class="card-header">
                <div class="card-icon">💳</div>
                <div class="card-title">Payment Info</div>
            </div>
            @if($order->payment)
            <div class="payment-grid">
                <div class="pay-row">
                    <span class="pay-key">Method</span>
                    <span class="pay-val">{{ ucfirst($order->payment->payment_type ?? '-') }}</span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Transaction ID</span>
                    <span class="pay-val" style="font-size:11px;word-break:break-all;">
                        {{ $order->payment->transaction_id ?? '-' }}
                    </span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Status</span>
                    <span class="pay-val">
                        @php
                            $pStatus = $order->payment->transaction_status ?? 'pending';
                            $pClass  = in_array($pStatus, ['settlement', 'capture']) ? 'paid' : ($pStatus === 'pending' ? 'pending' : 'cancelled');
                        @endphp
                        <span class="status-badge {{ $pClass }}" style="padding:3px 10px;font-size:11px;">
                            {{ ucfirst($pStatus) }}
                        </span>
                    </span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Date</span>
                    <span class="pay-val" style="font-size:12px;">
                        {{ $order->payment->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            @else
            <div style="padding:20px;text-align:center;">
                <div style="font-size:28px;margin-bottom:8px;">💳</div>
                <div style="font-size:13px;color:#9ca3af;">No payment recorded yet</div>
            </div>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="sidebar-card">
            <div class="card-header">
                <div class="card-icon">📋</div>
                <div class="card-title">Summary</div>
            </div>
            <div class="payment-grid">
                <div class="pay-row">
                    <span class="pay-key">Order ID</span>
                    <span class="pay-val" style="color:#6366f1;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Items</span>
                    <span class="pay-val">{{ $order->items->count() }} item(s)</span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Tickets</span>
                    <span class="pay-val">{{ $order->tickets->count() }} ticket(s)</span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Created</span>
                    <span class="pay-val" style="font-size:12px;">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="divider-line"></div>
                <div class="pay-row">
                    <span class="pay-key">Updated</span>
                    <span class="pay-val" style="font-size:12px;">{{ $order->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection