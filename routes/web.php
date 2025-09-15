<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
| Aquí se registran las rutas para la aplicación web. Estas rutas son
| cargadas por RouteServiceProvider dentro de un grupo que contiene
| el middleware "web". Ahora ¡creemos algo grandioso!
*/

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('clients', ClientController::class)->except(['show']);
});

// Temporary debug route - remove later
Route::get('/_debug/routes', function () {
    $names = collect(Route::getRoutes())->map(function ($r) { return $r->getName(); })->filter()->values();
    return response()->json([
        'count' => $names->count(),
        'names' => $names->all(),
        'has_login_post' => in_array('login.post', $names->all()),
    ]);
});

// Simple no-layout runtime sanity check for route names
Route::get('/_debug/no-layout', function () {
    $names = collect(Route::getRoutes())->map(function ($r) { return $r->getName(); })->filter()->values();
    return response()->json([
        'has_dashboard' => $names->contains('dashboard'),
        'has_login_post' => $names->contains('login.post'),
    ]);
});