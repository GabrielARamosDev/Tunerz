<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\App\VehicleController;
use App\Http\Controllers\App\EngineController;
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

    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users',
    ], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
    });

    Route::group([
        'namespace' => 'User',
        'prefix' => 'user',
    ], function () {
        Route::get('/vehicles', [UserController::class, 'vehicles']);
        Route::post('/vehicle', [UserController::class, 'addVehicle']);
        Route::delete('/vehicle/{id}', [UserController::class, 'removeVehicle']);
    });

    Route::group([
        'namespace' => 'Vehicles',
        'prefix' => 'vehicles',
    ], function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::post('/', [VehicleController::class, 'store']);
        
        Route::get('/{id}', [VehicleController::class, 'show']);
        Route::get('/info', [VehicleController::class, 'retrieve']);
        
        Route::get('/options/manufacturers', [VehicleController::class, 'getManufacturers']);
        Route::get('/options/models', [VehicleController::class, 'getModels']);
        Route::get('/options/trims', [VehicleController::class, 'getTrims']);
        Route::get('/options/years', [VehicleController::class, 'getYears']);
        Route::get('/options/generations', [VehicleController::class, 'getGenerations']);
    });

    Route::group([
        'namespace' => 'Engines',
        'prefix' => 'engines',
    ], function () {
        Route::get('/', [EngineController::class, 'index']);
        Route::get('/{id}', [EngineController::class, 'show']);
    });

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
