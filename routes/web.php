<?php

use App\Http\Controllers\EventExplorerController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/report', [ReportController::class, 'index']);
Route::get('/events/naive', [EventExplorerController::class, 'naive']);
Route::get('/events/search', [EventExplorerController::class, 'search']);
Route::get('/events/filter', [EventExplorerController::class, 'filter']);
Route::get('/events', [EventExplorerController::class, 'index']);
