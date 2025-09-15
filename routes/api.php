<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\ClientController as ApiClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aquí se registran las rutas para la API del sistema. Estas rutas son
| cargadas por RouteServiceProvider y todas ellas están asignadas al
| grupo de middleware "api". Disfruta construyendo tu API.
*/

// Ruta pública para autenticación vía API
Route::post('/login', [AuthController::class, 'apiLogin']);

// Agrupar rutas que requieren autenticación mediante tokens de Sanctum
Route::middleware('auth:sanctum')->name('api.')->group(function () {
    // API resources use the 'api.' name prefix to avoid colliding with web route names
    Route::apiResource('users', ApiUserController::class);
    Route::apiResource('products', ApiProductController::class);
    Route::apiResource('clients', ApiClientController::class);
    // Ruta para revocar el token actual del usuario autenticado
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    });
});