<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    // Get the Events and their related spaces
    $events = Event::with('space')->get();
    return view('home', ['events' => $events]);
});
// Register routes
Route::get('/register', function () {
    return view('register');
});
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);

// Login routes
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [UserController::class, 'login']);

// Events 
// Routes are protected, only authed users can create edit delete events
Route::middleware(['auth'])->group(function () {
    Route::get('/events/new', [EventController::class, 'new']);
    Route::post('/events/create', [EventController::class, 'create']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

});
// Events public show route
Route::get('/events/{event}', [EventController::class, 'show']);
