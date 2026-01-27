<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    $events = Event::all();
    return view('home', ['events' => $events]);
});
// Register routes
Route::get('/register', function () {
    return view('register');
});
Route::post('/register',[UserController::class,'register']);
Route::post('/logout',[UserController::class,'logout']);

// Login routes
Route::get('/login', function () {
    return view('login');
});
Route::post('/login',[UserController::class,'login']);

// Events crud routes
// Routes are protected, only authed users can create edit delete events
Route::middleware(['auth'])->group(function () {
    Route::get('/events/new', [EventController::class, 'new-event']);
    Route::post('/events/create', [EventController::class, 'create']);
});