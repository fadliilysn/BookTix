<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    /**
     * Daftar semua order milik user yang login
     */
    public function index()
    {
        $orders = Order::with(['items.event', 'payment', 'tickets'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail order milik user
     */
    public function show(Order $order)
    {
        // Pastikan hanya pemilik order yang bisa lihat
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.event', 'payment', 'tickets.event']);

        return view('orders.show', compact('order'));
    }
}