<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas

    //Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard'); //Rota S03

    Route::post('/exercises', [ExerciseController::class, 'store']); //Rota S04

    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index'); //Rota S05

    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy'])->name('exercises.destroy'); // Rota S06

    Route::post('/students', [StudentController::class, 'store'])->middleware('validate.students.limit'); // Rota 07

});

// rota pública de registro de usuário
Route::post('/users', [UserController::class, 'store']); //Rota S01

// rota pública de login
Route::post('/login', [AuthController::class, 'store'])->name('login'); // Rota S02

