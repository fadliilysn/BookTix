@extends('layouts.user')

@section('title', 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' — BookTix')

@section('content')

<style>
    .container { max-width: 900px; margin: 0 auto; padding: 40px 24px 60px; }

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13px; color: var(--text-3); text-decoration: none;
        margin-bottom: 24px; transition: color 0.15s;
    }
    .back-link:hover { color: var(--text); }

    .order-top {
        display: flex; align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
        margin-bottom: 24px;
    }

    .order-title {
        font-family: 'Fraunces', serif;
        font-size: 26px; font-weight: 700;
        color: var(--text); letter-spacing: -0.5px;
    }

    .order-date-text { font-size: 13px; color: var(--text-3); margin-top: 4px; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }

    .status-badge.pending   { background: #fffbeb; color: #d97706; }
    .status-badge.paid      { background: #ecfdf5; color: #059669; }
    .status-badge.cancelled { background: #fff1f2; color: #e11d48; }

    [data-theme="dark"] .status-badge.pending   { background: #451a03; color: #fbbf24; }
    [data-theme="dark"] .status-badge.paid      { background: #052e16; color: #4ade80; }
    [data-theme="dark"] .status-badge.cancelled { background: #2d0a0a; color: #f87171; }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .card-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }

    .card-icon {
        width: 28px; height: 28px; border-radius: 7px;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 14px; font-weight: 600; color: var(--text);
    }

    .items-table { width: 100%; border-collapse: collapse; }

    .items-table th {
        padding: 10px 20px;
        font-size: 10px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: var(--text-3); background: var(--bg);
        text-align: left;
    }

    .items-table td {
        padding: 14px 20px;
        font-size: 13px; color: var(--text-2);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .items-table tr:last-child td { border-bottom: none; }

    .event-name-cell { font-weight: 500; color: var(--text); }
    .event-meta-cell { font-size: 11.5px; color: var(--text-3); margin-top: 2px; }

    .total-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 16px 20px; border-top: 2px solid var(--border);
        background: var(--bg);
    }

    .total-label { font-size: 14px; font-weight: 600; color: var(--text-2); }
    .total-value {
        font-family: 'Fraunces', serif;
        font-size: 22px; font-weight: 700; color: var(--text);
    }

    .info-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 14px; padding: 20px;
    }

    .info-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-3); margin-bottom: 4px; }
    .info-value { font-size: 14px; font-weight: 500; color: var(--text); }

    .ticket-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid var(--border);
    }

    .ticket-item:last-child { border-bottom: none; }

    .ticket-code {
        font-family: 'Courier New', monospace;
        font-size: 13px; font-weight: 700;
        color: var(--accent); background: var(--accent-soft);
        padding: 5px 12px; border-radius: 7px;
        letter-spacing: 1px; flex: 1;
    }

    .ticket-event { font-size: 12px; color: var(--text-3); }

    /* Payment pending box */
    .payment-pending-box {
        background: linear-gradient(135deg, var(--accent-soft), rgba(99,102,241,0.03));
        border: 1.5px solid rgba(99,102,241,0.2);
        border-radius: 14px;
        padding: 28px;
        text-align: center;
        margin-bottom: 16px;
    }

    .payment-pending-box .icon { font-size: 36px; margin-bottom: 10px; }

    .payment-pending-box h3 {
        font-family: 'Fraunces', serif;
        font-size: 18px; font-weight: 700;
        color: var(--text); margin-bottom: 6px;
    }

    .payment-pending-box p {
        font-size: 13px; color: var(--text-2); margin-bottom: 16px;
    }

    .total-display {
        font-family: 'Fraunces', serif;
        font-size: 32px; font-weight: 700;
        color: var(--text); margin-bottom: 20px;
    }

    /* Pay button */
    .pay-now-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 14px 32px;
        background: var(--accent); color: white;
        border-radius: 12px; font-size: 15px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none; cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 3px 14px rgba(99,102,241,0.35);
    }

    .pay-now-btn:hover:not(:disabled) {
        background: var(--accent-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.45);
    }

    .pay-now-btn:disabled {
        opacity: 0.6; cursor: not-allowed; transform: none;
    }

    .pay-loading {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--text-3);
        margin-top: 10px;
    }

    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner {
        width: 14px; height: 14px;
        border: 2px solid var(--border);
        border-top-color: var(--accent);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    /* Flash */
    .flash-success {
        background: #ecfdf5; border: 1px solid #bbf7d0; color: #16a34a;
        padding: 12px 16px; border-radius: 10px; font-size: 13px;
        margin-bottom: 16px; display: flex; gap: 8px; align-items: center;
    }

    [data-theme="dark"] .flash-success { background: #052e16; border-color: #166534; color: #4ade80; }

    @media (max-width: 600px) {
        .info-grid { grid-template-columns: 1fr; }
        .order-top { flex-direction: column; }
    }
</style>

{{-- Midtrans Snap JS --}}
@if($order->status === 'pending')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<div class="container">

    <a href="{{ route('orders.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali ke My Orders
    </a>

    <div class="order-top">
        <div>
            <div class="order-title">
                Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </div>
            <div class="order-date-text">
                Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}
            </div>
        </div>
        <span class="status-badge {{ $order->status }}">
            @if($order->status === 'pending') ⏳
            @elseif($order->status === 'paid') ✅
            @else ❌
            @endif
            {{ ucfirst($order->status) }}
        </span>
    </div>

    @if(session('success'))
    <div class="flash-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Pending: tombol bayar dengan Midtrans Snap --}}
    @if($order->status === 'pending')
    <div class="payment-pending-box">
        <div class="icon">💳</div>
        <h3>Selesaikan Pembayaran</h3>
        <p>Order kamu sedang menunggu pembayaran. Total yang harus dibayar:</p>
        <div class="total-display">
            @if($order->total_price == 0)
                <span style="color:#059669;">FREE</span>
            @else
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            @endif
        </div>

        <button class="pay-now-btn" id="payBtn" onclick="startPayment()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>
            </svg>
            Bayar Sekarang
        </button>

        <div class="pay-loading" id="loadingIndicator" style="display:none;">
            <div class="spinner"></div>
            Memuat payment gateway...
        </div>
    </div>
    @endif

    {{-- Item pesanan --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon">🎟️</div>
            <div class="card-title">Item Pesanan</div>
        </div>
        <div style="overflow-x:auto;">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="event-name-cell">{{ $item->event->title ?? 'Event deleted' }}</div>
                            @if($item->event && $item->event->event_date)
                            <div class="event-meta-cell">
                                📅 {{ \Carbon\Carbon::parse($item->event->event_date)->format('d M Y, H:i') }}
                                @if($item->event->location) · 📍 {{ $item->event->location }} @endif
                            </div>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item->event->price ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align:right;font-weight:600;color:var(--text);">
                            Rp {{ number_format(($item->event->price ?? 0) * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="total-row">
            <span class="total-label">Total Pembayaran</span>
            <span class="total-value">
                @if($order->total_price == 0)
                    <span style="color:#059669;">FREE</span>
                @else
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                @endif
            </span>
        </div>
    </div>

    {{-- Payment info --}}
    @if($order->payment)
    <div class="card">
        <div class="card-header">
            <div class="card-icon">💳</div>
            <div class="card-title">Info Pembayaran</div>
        </div>
        <div class="info-grid">
            <div>
                <div class="info-label">Metode</div>
                <div class="info-value">{{ ucfirst($order->payment->payment_type ?? '-') }}</div>
            </div>
            <div>
                <div class="info-label">Status</div>
                <div class="info-value">
                    @php
                        $pStatus = $order->payment->transaction_status ?? 'pending';
                        $pClass  = in_array($pStatus, ['settlement', 'capture']) ? 'paid' : ($pStatus === 'pending' ? 'pending' : 'cancelled');
                    @endphp
                    <span class="status-badge {{ $pClass }}" style="padding:3px 10px;font-size:11px;">
                        {{ ucfirst($pStatus) }}
                    </span>
                </div>
            </div>
            <div>
                <div class="info-label">Transaction ID</div>
                <div class="info-value" style="font-size:12px;word-break:break-all;">
                    {{ $order->payment->transaction_id ?? '-' }}
                </div>
            </div>
            <div>
                <div class="info-label">Tanggal</div>
                <div class="info-value" style="font-size:13px;">{{ $order->payment->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Tiket (hanya tampil jika sudah paid) --}}
    @if($order->status === 'paid' && $order->tickets->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <div class="card-icon">🎫</div>
            <div class="card-title">Tiket Kamu ({{ $order->tickets->count() }})</div>
        </div>
        @foreach($order->tickets as $ticket)
        <div class="ticket-item">
            <div class="ticket-code">{{ $ticket->ticket_code }}</div>
            <div class="ticket-event">{{ $ticket->event->title ?? '-' }}</div>
        </div>
        @endforeach
    </div>
    @endif

</div>

@if($order->status === 'pending')
<script>
    async function startPayment() {
        const btn = document.getElementById('payBtn');
        const loading = document.getElementById('loadingIndicator');

        btn.disabled = true;
        loading.style.display = 'inline-flex';

        try {
            // Request snap token dari backend
            const res = await fetch('{{ route('payment.snap-token', $order) }}', {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            });

            const data = await res.json();

            if (data.error) {
                alert('Error: ' + data.error);
                btn.disabled = false;
                loading.style.display = 'none';
                return;
            }

            // Tampilkan Snap popup
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Redirect ke halaman order setelah sukses
                    window.location.href = '{{ route('orders.show', $order) }}?payment=success';
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    btn.disabled = false;
                    loading.style.display = 'none';
                },
                onClose: function() {
                    // User menutup popup tanpa bayar
                    btn.disabled = false;
                    loading.style.display = 'none';
                }
            });

        } catch (err) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            loading.style.display = 'none';
        }
    }
</script>
@endif

@endsection