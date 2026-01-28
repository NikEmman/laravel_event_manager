<?php


use App\Http\Controllers\Api\V1\EventController;

Route::prefix('v1')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
});