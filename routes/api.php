<?php


use App\Http\Controllers\Api\V1\EventController;

// Rate limit the exposed API to avoid scrapping bots overwhelming the db

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
});