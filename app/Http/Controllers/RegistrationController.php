<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function store(Event $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $eventWithLock = Event::where('id', $event->id)
                    ->lockForUpdate()
                    ->first();

                if ($eventWithLock->attendees()->count() >= $eventWithLock->limit) {
                    throw new \Exception('Sajnos minden hely elkelt!');
                }

                $alreadyRegistered = Registration::where('user_id', Auth::id())
                    ->where('event_id', $event->id)
                    ->exists();

                if ($alreadyRegistered) {
                    throw new \Exception('Már jelentkeztél erre az eseményre!');
                }

                Registration::create([
                    'user_id' => Auth::id(),
                    'event_id' => $event->id,
                ]);
            });

            $event->refresh();
            $event->load('attendees');

            return back()->with('message', 'Sikeresen jelentkeztél!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
