<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $query = Event::with('creator');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $events = $query->orderByRaw("CASE 
                WHEN status = 'ongoing' THEN 1 
                WHEN status = 'upcoming' THEN 2 
                WHEN status = 'completed' THEN 3 
                ELSE 4 
            END")
            ->orderBy('event_date', 'desc')
            ->paginate(10)
            ->withQueryString();
        $statuses = EventStatus::options();

        return view('admin.events.index', compact('events', 'statuses'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'location' => ['required', 'string', 'max:255'],
        ], [
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $event = Event::create([
            ...$validated,
            'created_by' => auth()->id(),
            'status' => EventStatus::UPCOMING,
        ]);

        \App\Services\ActivityLogger::log('create', "Menambahkan kegiatan baru: {$event->title}", $event);

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $statuses = EventStatus::options();
        return view('admin.events.edit', compact('event', 'statuses'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(EventStatus::class)],
        ]);

        $event->update($validated);

        \App\Services\ActivityLogger::log('update', "Mengubah data kegiatan: {$event->title}", $event);

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        \App\Services\ActivityLogger::log('delete', "Menghapus kegiatan: {$event->title}", $event);

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
