<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Generate Midtrans Snap Token untuk order
     */
    public function snapToken(Order $order)
    {
        // Hanya pemilik order yang bisa generate token
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Order sudah tidak pending.'], 400);
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_code . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email'      => $order->user->email,
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id'       => $item->event_id,
                    'price'    => (int) $item->event->price,
                    'quantity' => $item->quantity,
                    'name'     => $item->event->title ?? 'Event Ticket',
                ];
            })->toArray(),
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}