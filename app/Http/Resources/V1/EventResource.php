<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->name,
            'description' => $this->description,
            'event_date' => $this->event_date->format('Y-m-d H:i'),
            'max_limit' => $this->limit,
            'available_slots' => $this->limit - $this->attendees()->count(),
            'organizer' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'image' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'links' => [
                'self' => route('api.events.show', $this->id),
            ],
        ];
    }
}