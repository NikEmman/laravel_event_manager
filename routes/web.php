<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('home');
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

