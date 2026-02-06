<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* * */

Route::group([
    'middleware' => [ 'auth:sanctum' ],
    'namespace' => 'App',
    'prefix' => 'app',
], function () {

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::get('/me', [UserController::class, 'me']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

    Route::get('/vehicles/{id}/stages', [StageController::class, 'byVehicle']);
    Route::get('/stages/{id}', [StageController::class, 'show']);

    Route::get('/vehicles/{id}/modules', [ModuleController::class, 'byVehicle']);

});

Route::group([
    'middleware' => [
        'auth:api', 
        'role:admin', 
    ],
    'namespace' => 'App',
    'prefix' => 'app',
], function () {
    


});

/* * */

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
