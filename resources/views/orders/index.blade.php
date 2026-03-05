@extends('layouts.user')

@section('title', 'My Orders — BookTix')

@section('content')

<style>
    .container { max-width: 900px; margin: 0 auto; padding: 40px 24px 60px; }

    .page-title {
        font-family: 'Fraunces', serif;
        font-size: 28px; font-weight: 700;
        color: var(--text); letter-spacing: -0.5px;
        margin-bottom: 6px;
    }

    .page-sub { font-size: 14px; color: var(--text-3); margin-bottom: 32px; }

    /* Order card */
    .order-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
        text-decoration: none;
        display: block;
        transition: all 0.2s;
    }

    .order-card:hover {
        border-color: var(--accent);
        box-shadow: 0 4px 20px rgba(99,102,241,0.08);
        transform: translateY(-1px);
    }

    .order-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-id {
        font-family: 'Fraunces', serif;
        font-size: 15px; font-weight: 700;
        color: var(--accent);
    }

    .order-date { font-size: 12px; color: var(--text-3); margin-top: 2px; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px;
        font-size: 11px; font-weight: 600;
    }

    .status-badge.pending   { background: #fffbeb; color: #d97706; }
    .status-badge.paid      { background: #ecfdf5; color: #059669; }
    .status-badge.cancelled { background: #fff1f2; color: #e11d48; }

    [data-theme="dark"] .status-badge.pending   { background: #451a03; color: #fbbf24; }
    [data-theme="dark"] .status-badge.paid      { background: #052e16; color: #4ade80; }
    [data-theme="dark"] .status-badge.cancelled { background: #2d0a0a; color: #f87171; }

    .order-body {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .order-items { flex: 1; }

    .order-item-line {
        font-size: 13px; color: var(--text-2);
        margin-bottom: 4px;
        display: flex; align-items: center; gap: 6px;
    }

    .order-item-line strong { color: var(--text); }

    .order-total {
        text-align: right;
    }

    .total-amount {
        font-family: 'Fraunces', serif;
        font-size: 20px; font-weight: 700;
        color: var(--text);
    }

    .total-label { font-size: 11px; color: var(--text-3); margin-top: 2px; }

    .view-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px;
        background: var(--accent-soft);
        color: var(--accent);
        border-radius: 8px;
        font-size: 12px; font-weight: 600;
        margin-top: 8px;
    }

    /* Empty */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
    }

    .empty-icon  { font-size: 52px; margin-bottom: 16px; }
    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 20px; font-weight: 600;
        color: var(--text); margin-bottom: 8px;
    }
    .empty-desc { font-size: 14px; color: var(--text-3); margin-bottom: 20px; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px;
        background: var(--accent); color: white;
        border-radius: 10px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: all 0.15s;
    }

    .btn-primary:hover { background: var(--accent-dark); }
</style>

<div class="container">
    <div class="page-title">My Orders</div>
    <div class="page-sub">Riwayat pembelian tiket kamu</div>

    @forelse($orders as $order)
    <a href="{{ route('orders.show', $order) }}" class="order-card">
        <div class="order-header">
            <div>
                <div class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            <span class="status-badge {{ $order->status }}">
                @if($order->status === 'pending') ⏳
                @elseif($order->status === 'paid') ✅
                @else ❌
                @endif
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="order-body">
            <div class="order-items">
                @foreach($order->items->take(2) as $item)
                <div class="order-item-line">
                    🎟️ <strong>{{ $item->quantity }}x</strong> {{ $item->event->title ?? 'Event deleted' }}
                </div>
                @endforeach
                @if($order->items->count() > 2)
                <div class="order-item-line" style="color:var(--accent);">
                    +{{ $order->items->count() - 2 }} more item
                </div>
                @endif

                <div class="view-btn">
                    Lihat Detail
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>

            <div class="order-total">
                @if($order->total_price == 0)
                    <div class="total-amount" style="color:#059669;">FREE</div>
                @else
                    <div class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                @endif
                <div class="total-label">{{ $order->tickets->count() }} tiket</div>
            </div>
        </div>
    </a>
    @empty
    <div class="empty-state">
        <div class="empty-icon">🎟️</div>
        <div class="empty-title">Belum ada order</div>
        <div class="empty-desc">Kamu belum pernah memesan tiket. Yuk cari event yang menarik!</div>
        <a href="{{ route('events.index') }}" class="btn-primary">
            Browse Events
        </a>
    </div>
    @endforelse

    @if($orders->hasPages())
    <div style="display:flex;justify-content:center;margin-top:24px;">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection