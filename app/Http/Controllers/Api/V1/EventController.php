<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\V1\EventResource;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        return EventResource::collection($events);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Esemény nem található'], 404);
        }

        return new EventResource($event);
    }
}