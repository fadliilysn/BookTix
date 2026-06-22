<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['available_quota']   = $validated['quota'];
        $validated['created_by']        = auth()->id();
        $validated['slug']              = Str::slug($validated['title']) . '-' . uniqid();
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        // Hapus gambar kalau diminta
        if ($request->input('remove_image') == '1' && $event->image) {
            Storage::disk('public')->delete($event->image);
            $validated['image'] = null;
        }

        // Atau ganti dengan gambar baru
        if ($request->hasFile('image')) {
            if ($event->image) Storage::disk('public')->delete($event->image);
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

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
