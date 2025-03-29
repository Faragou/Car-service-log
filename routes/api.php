<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Client Routes
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}/cars', [ClientController::class, 'getCars']);

    // Car Routes
    Route::get('/clients/{clientId}/cars/{carIndex}/servicelogs', [CarController::class, 'getServiceLogs']);
    Route::get('searchClients', [ClientController::class, 'searchClient']);


});
