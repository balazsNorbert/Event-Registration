<?php

use App\Http\Controllers\Api\V1\EventController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('/events', [EventController::class, 'index'])
         ->middleware('throttle:60,1')
         ->name('api.events.index');

    Route::get('/events/{id}', [EventController::class, 'show'])
         ->middleware('throttle:60,1')
         ->name('api.events.show');
});