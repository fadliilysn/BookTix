<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'price' => 'required|integer',
            'quota' => 'required|integer',
        ]);

        $validated['available_quota'] = $validated['quota'];
        $validated['created_by'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'price' => 'required|integer',
            'quota' => 'required|integer',
        ]);

        // Jika quota dinaikkan, sesuaikan available_quota
        if ($validated['quota'] > $event->quota) {
            $difference = $validated['quota'] - $event->quota;
            $event->available_quota += $difference;
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}
