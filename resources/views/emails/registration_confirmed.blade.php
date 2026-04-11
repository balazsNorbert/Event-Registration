<x-mail::message>
# Kedves {{ $user->name }}!

Sikeresen jelentkeztél a következő eseményre: **{{ $event->name }}**.

**Időpont:** {{ $event->event_date }}

<x-mail::button :url="route('events.index')">
Események megtekintése
</x-mail::button>

Üdvözlettel,<br>
{{ config('app.name') }}
</x-mail::message>
