<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\StageController;

use Illuminate\Support\Facades\Route;

// Route::get('/ping', fn () => ['pong']);

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

Route::get('/vehicles/{id}/modules', [ModuleController::class, 'byVehicle']);

Route::get('/vehicles/{id}/stages', [StageController::class, 'byVehicle']);
Route::get('/stages/{id}', [StageController::class, 'show']);
