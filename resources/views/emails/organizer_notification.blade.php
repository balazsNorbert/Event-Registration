<x-mail::message>
# Szia {{ $event->user->name }}!

Új jelentkező érkezett az eseményedre.

**Esemény:** {{ $event->name }}
**Jelentkező neve:** {{ $attendee->name }}
**Jelentkező e-mail címe:** {{ $attendee->email }}
**Időpont:** {{ now()->format('Y.m.d. H:i') }}

<x-mail::button :url="route('events.show', $event->id)">
Esemény megtekintése
</x-mail::button>

Üdvözlettel,<br>
{{ config('app.name') }}
</x-mail::message>
