<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Note;
use App\Models\Participant;
use App\Models\Venue;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::withCount('events')->orderBy('name')->get();
        $allEvents = Event::orderBy('title')->get();
        $allPeople = Participant::orderBy('name')->get();

        $venueId = $request->integer('venue', $venues->first()->id);
        $eventId = $request->integer('event', $allEvents->first()->id);
        $personId = $request->integer('participant', $allPeople->first()->id);

        $chosenVenue = Venue::with(['events', 'notes'])->findOrFail($venueId);
        $chosenEvent = Event::with(['participants', 'notes'])->findOrFail($eventId);
        $chosenPerson = Participant::with('events')->findOrFail($personId);
        $waitlistedEvents = Event::whereHas('participants',
            fn ($q) => $q->where('event_participant.status', 'waitlisted'))->get();
        $notes = Note::with('noteable')->get();

        return view('report', compact('venues', 'allEvents', 'allPeople', 'chosenVenue',
            'chosenEvent', 'chosenPerson', 'waitlistedEvents', 'notes'));
    }
}
