<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;


Route::get('/events', function () {
    return Event::all();
});