<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.event', 'payment'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by user name or email
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid'    => Order::where('status', 'paid')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('status', 'paid')->sum('total_price'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.event', 'payment', 'tickets.event']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $newStatus      = $request->status;
        $previousStatus = $order->status;

        // Tidak ada perubahan, skip
        if ($previousStatus === $newStatus) {
            return back()->with('success', 'Status order tidak berubah.');
        }

        DB::transaction(function () use ($order, $newStatus, $previousStatus) {
            $order->update(['status' => $newStatus]);

            // Restore quota jika di-cancel (dan sebelumnya bukan cancelled)
            if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->event) {
                        $item->event->increment('available_quota', $item->quantity);
                    }
                }
            }

            // Generate tiket jika admin set ke paid dan belum ada tiket
            if ($newStatus === 'paid' && $order->tickets()->count() === 0) {
                $order->load('items.event');
                foreach ($order->items as $item) {
                    for ($i = 0; $i < $item->quantity; $i++) {
                        do {
                            $code = 'BTX-' . $item->event_id . '-' . strtoupper(Str::random(8));
                        } while (Ticket::where('ticket_code', $code)->exists());

                        Ticket::create([
                            'order_id'    => $order->id,
                            'event_id'    => $item->event_id,
                            'user_id'     => $order->user_id,
                            'ticket_code' => $code,
                            'status'      => 'unused',
                        ]);
                    }
                }
            }
        });

        return back()->with('success', 'Status order berhasil diperbarui.');
    }
}