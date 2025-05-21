<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRolController;
use App\Http\Controllers\CuentaPadreController;
use App\Http\Controllers\CuentaHijaController;
use App\Http\Controllers\AreaCuentaController;
// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']); // Registro
Route::post('/login', [AuthController::class, 'login']); // Login

// Protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user()); // Obtener usuario autenticado
    });

    Route::post('/logout', [AuthController::class, 'logout']); // Cerrar sesión
});



Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente 🚀']);
});

Route::get('/user_rol/{id}', [UserRolController::class, 'getRol']);



Route::get('/cuenta-padre', [CuentaPadreController::class, 'index']);
Route::get('/cuenta-padre/inactivas', [CuentaPadreController::class, 'cuentasInactivas']);
Route::post('/cuenta-padre/crear', [CuentaPadreController::class, 'store']);
Route::get('/cuenta-padre/{id}', [CuentaPadreController::class, 'show']);
Route::put('/cuenta-padre/editar/{id}', [CuentaPadreController::class, 'update']);
Route::delete('/cuenta-padre/eliminar/{id}', [CuentaPadreController::class, 'destroy']);
Route::get('cuentaspadre/{id}', [CuentaPadreController::class, 'obtenerCodigoPorId']);
Route::get('/ids', [CuentaPadreController::class, 'listarSoloIds']);

Route::get('/hijas', [CuentaHijaController::class, 'index']);
Route::get('/hijas2/{id}', [CuentaHijaController::class, 'index2']);
Route::delete('/cuentas-hijas/eliminar/{id}', [CuentaHijaController::class, 'destroy']);
Route::put('/cuentas-hijas/editar/{id}', [CuentaHijaController::class, 'update']);
Route::post('/hija/crear', [CuentaHijaController::class, 'store']);
Route::get('/verhija/{id}', [CuentaHijaController::class, 'show']);


Route::post('/area-cuenta/agregar', [AreaCuentaController::class, 'store']);
Route::put('/area-cuenta/editar/{id}', [AreaCuentaController::class, 'editar']);
Route::delete('/area-cuenta/eliminar/{id}', [AreaCuentaController::class, 'eliminar']);
Route::get('/area-cuenta/listar', [AreaCuentaController::class, 'listarActivos']);

Route::get('/cuenta-hija/{id}/nombre', [CuentaHijaController::class, 'obtenerNombre']);
