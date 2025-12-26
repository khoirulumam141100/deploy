<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Event::query();

        if ($filter === 'ongoing') {
            $query->ongoing();
        } elseif ($filter === 'upcoming') {
            $query->upcoming();
        } elseif ($filter === 'completed') {
            $query->completed();
        }

        // Order by status priority: ongoing first, then upcoming, then completed
        $events = $query->orderByRaw("CASE 
                WHEN status = 'ongoing' THEN 1 
                WHEN status = 'upcoming' THEN 2 
                WHEN status = 'completed' THEN 3 
                ELSE 4 
            END")
            ->orderBy('event_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('member.events.index', compact('events', 'filter'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('member.events.show', compact('event'));
    }
}
