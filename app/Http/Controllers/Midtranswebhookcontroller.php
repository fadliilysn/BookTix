<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransWebhookController extends Controller
{
    /**
     * Handle incoming Midtrans payment notification.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans webhook received', $payload);

        // ── 1. VERIFIKASI SIGNATURE ──────────────────────────────────────
        // Format: SHA512(order_id + status_code + gross_amount + server_key)
        $serverKey      = config('midtrans.server_key');
        $orderId        = $payload['order_id']      ?? '';
        $statusCode     = $payload['status_code']   ?? '';
        $grossAmount    = $payload['gross_amount']   ?? '';
        $signatureKey   = $payload['signature_key'] ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans webhook: invalid signature', [
                'order_id' => $orderId,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ── 2. CARI ORDER ────────────────────────────────────────────────
        // order_id di Midtrans = "{order_code}-{timestamp}" (timestamp = 10 digit Unix)
        // Gunakan LIKE agar aman meski order_code mengandung angka di akhir
        $order = Order::with(['items.event', 'payment'])
                    ->where('order_code', $orderId)
                    ->orWhere(function ($q) use ($orderId) {
                        // Hapus suffix "-{10 digit timestamp}" di akhir
                        $q->whereRaw("? LIKE CONCAT(order_code, '-%')", [$orderId]);
                    })
                    ->first();

        if (!$order) {
            Log::warning('Midtrans webhook: order not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ── 3. TENTUKAN STATUS BERDASARKAN RESPONSE MIDTRANS ────────────
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? '';
        $paymentType       = $payload['payment_type']       ?? '';

        $orderStatus  = $this->resolveOrderStatus($transactionStatus, $fraudStatus);
        $paymentStatus = $this->resolvePaymentStatus($transactionStatus, $fraudStatus);

        // ── 4. UPDATE DATABASE DALAM TRANSACTION ────────────────────────
        DB::transaction(function () use ($order, $payload, $orderStatus, $paymentStatus, $paymentType, $grossAmount) {

            // Update atau buat Payment record
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id'     => $payload['transaction_id'] ?? null,
                    'payment_type'       => $paymentType,
                    'transaction_status' => $transactionStatus,
                    'raw_response'       => json_encode($payload),
                ]
            );

            // Jika belum berubah ke status yang sama, update order
            if ($order->status !== $orderStatus) {
                $previousStatus = $order->status;
                $order->update(['status' => $orderStatus]);

                // ── 5. GENERATE TIKET JIKA PEMBAYARAN SUKSES ──────────────
                if ($orderStatus === 'paid' && $order->tickets()->count() === 0) {
                    $this->generateTickets($order);
                }

                // ── 6. KEMBALIKAN QUOTA JIKA CANCELLED/EXPIRED ────────────
                // Hanya restore jika sebelumnya bukan cancelled (hindari double restore)
                if ($orderStatus === 'cancelled' && $previousStatus !== 'cancelled') {
                    $this->restoreQuota($order);
                }
            }
        });

        Log::info('Midtrans webhook: order updated', [
            'order_id'     => $order->id,
            'order_status' => $orderStatus,
        ]);

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Tentukan status Order berdasarkan transaction_status dari Midtrans.
     */
    private function resolveOrderStatus(string $transactionStatus, string $fraudStatus): string
    {
        // settlement  = transfer bank / e-wallet berhasil settle
        // capture     = kartu kredit berhasil di-capture
        // pending     = menunggu pembayaran
        // cancel      = dibatalkan
        // expire      = kadaluarsa
        // deny        = ditolak (fraud)

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'paid' : 'cancelled';
        }

        return match ($transactionStatus) {
            'settlement'         => 'paid',
            'pending'            => 'pending',
            'cancel', 'expire', 'deny' => 'cancelled',
            default              => 'pending',
        };
    }

    /**
     * Tentukan status Payment berdasarkan transaction_status dari Midtrans.
     */
    private function resolvePaymentStatus(string $transactionStatus, string $fraudStatus): string
    {
        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'paid' : 'failed';
        }

        return match ($transactionStatus) {
            'settlement'         => 'paid',
            'pending'            => 'pending',
            'cancel', 'expire', 'deny' => 'failed',
            default              => 'pending',
        };
    }

    /**
     * Generate tiket untuk setiap item dalam order.
     * Quantity > 1 akan menghasilkan tiket sebanyak quantity.
     */
    private function generateTickets(Order $order): void
    {
        foreach ($order->items as $item) {
            for ($i = 0; $i < $item->quantity; $i++) {
                Ticket::create([
                    'order_id'    => $order->id,
                    'event_id'    => $item->event_id,
                    'user_id'     => $order->user_id,
                    'ticket_code' => $this->generateUniqueCode($item->event_id),
                    'status'      => 'unused',
                ]);
            }
        }
    }

    /**
     * Generate kode tiket unik.
     * Format: BTX-{EVENT_ID}-{RANDOM 8 CHAR UPPERCASE}
     * Contoh: BTX-12-A3F8K2PQ
     */
    private function generateUniqueCode(int $eventId): string
    {
        do {
            $code = 'BTX-' . $eventId . '-' . strtoupper(Str::random(8));
        } while (Ticket::where('ticket_code', $code)->exists());

        return $code;
    }

    /**
     * Kembalikan available_quota ke event jika order dibatalkan.
     */
    private function restoreQuota(Order $order): void
    {
        // Hanya restore jika order sebelumnya bukan cancelled
        // (hindari restore ganda jika webhook dikirim 2x)
        foreach ($order->items as $item) {
            if ($item->event) {
                $item->event->increment('available_quota', $item->quantity);
            }
        }
    }
}