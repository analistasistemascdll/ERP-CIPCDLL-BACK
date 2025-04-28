<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRolController;


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







