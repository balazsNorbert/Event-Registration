<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'event_date', 'limit', 'image_path', 'user_id'];
    protected $casts = ['event_date' => 'datetime'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function attendees() {
        return $this->belongsToMany(User::class, 'registrations')->withTimestamps();
    }
}
