<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Homepage — tampil event upcoming
     */
    public function home()
    {
        // Di homepage, tampilkan semua event (tidak filter tanggal)
        // agar event yang sudah diinput admin langsung kelihatan
        $events = Event::whereNotNull('event_date')
            ->orderBy('event_date', 'asc')
            ->paginate(6);

        $totalEvents  = Event::count();
        $totalTickets = \App\Models\Ticket::count();

        return view('welcome', compact('events', 'totalEvents', 'totalTickets'));
    }

    /**
     * Events listing page — semua event + search + filter status
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Search by title or location
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by availability
        if ($request->status === 'available') {
            $query->where('available_quota', '>', 0);
        } elseif ($request->status === 'full') {
            $query->where('available_quota', '<=', 0);
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(9)->withQueryString();

        return view('events.index', compact('events'));
    }

    /**
     * Event detail page
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Process booking — buat Order + OrderItem
     */
    public function book(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Cek quota
        if ($event->available_quota < $request->quantity) {
            return back()->with('error', 'Stok tiket tidak cukup. Tersisa ' . $event->available_quota . ' tiket.');
        }

        $order = null;

        DB::transaction(function () use ($event, $request, &$order) {
            $event->decrement('available_quota', $request->quantity);

            $order = Order::create([
                'user_id'     => auth()->id(),
                'order_code'  => 'BTX-' . strtoupper(Str::random(10)),
                'total_price' => $event->price * $request->quantity,
                'status'      => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'event_id' => $event->id,
                'quantity' => $request->quantity,
                'subtotal' => $event->price * $request->quantity,
            ]);
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order berhasil! Silakan selesaikan pembayaran.');
    }
}