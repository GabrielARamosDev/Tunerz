<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\App\VehicleController;
use App\Http\Controllers\App\ModuleController;
use App\Http\Controllers\App\StageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong'
    ], 200);
});

/* ============================================================== */

Route::group([
    'middleware' => [ ],
    'namespace' => 'App',
], function () {

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

});

Route::group([
    'middleware' => [ 'auth:sanctum' ],
    'namespace' => 'App',
    // 'prefix' => 'app',
], function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/user/vehicles', [UserController::class, 'vehicles']);
    Route::post('/user/vehicle', [UserController::class, 'addVehicle']);
    Route::delete('/user/vehicle/{id}', [UserController::class, 'removeVehicle']);

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
    Route::get('/vehicles/info', [VehicleController::class, 'retrieve']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::get('/vehicles/options/manufacturers', [VehicleController::class, 'getManufacturers']);
    Route::get('/vehicles/options/models', [VehicleController::class, 'getModels']);
    Route::get('/vehicles/options/trims', [VehicleController::class, 'getTrims']);
    Route::get('/vehicles/options/years', [VehicleController::class, 'getYears']);

    Route::get('/engines', [ModuleController::class, 'index']);
    Route::get('/engines/{id}', [ModuleController::class, 'show']);

    Route::get('/stages/{id}', [StageController::class, 'show']);
    Route::get('/vehicles/{id}/stages', [StageController::class, 'byVehicle']);

    Route::get('/vehicles/{id}/modules', [ModuleController::class, 'byVehicle']);

});

Route::group([
    'middleware' => [
        'auth:sanctum', 
        'role:admin', 
    ],
    'namespace' => 'Admin_App',
    'prefix' => 'admin',
], function () {
    
});

/* ============================================================== */

// Route::prefix('v2')->group(function () {
//     Route::group([
//         // 'middleware' => ['auth:api', 'role:wp'],
//         // 'namespace' => 'App\Http\Controllers\Widgets',
//         'prefix' => 'scout',
//     ], function () {
//         // Widgets
//         Route::get('/widgets', 'WidgetControllerV2@getAll'); // listar todos
//         Route::get('/widgets/{widgetName}', 'WidgetControllerV2@makeWidget'); // Gerar uma url para cada tipo de widget
//     });
// });
