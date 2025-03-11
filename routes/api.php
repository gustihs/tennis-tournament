<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

Route::prefix('v1')->group(function () {
    Route::apiResource('tournaments', TournamentController::class)->only([
        'index', 'store'
    ]);
});