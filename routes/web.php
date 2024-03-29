<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlaceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [EventController::class, 'front'])->name('home');

Route::get('events/all', [EventController::class, 'all'])->name('events.all');
Route::get('teams/events/{team}', [TeamController::class, 'events'])->name('team.events');

Route::resource('events', EventController::class)->only([
    'index', 'show'
]);

Route::resource('teams', TeamController::class)->only([
    'index', 'show'
]);

Route::resource('places', PlaceController::class)->only([
    'index', 'show'
]);