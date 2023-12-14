<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
});

// rota pública de registro de usuário
Route::post('/users', [UserController::class, 'store']);

// rota pública de login
Route::post('/login', [AuthController::class, 'store']);



