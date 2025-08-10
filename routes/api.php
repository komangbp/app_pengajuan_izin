<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\VerifikatorController;
use Illuminate\Support\Facades\Route;

/*
| Public
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //User biasa
    Route::middleware('role:user,admin,verifikator')->group(function () {
        Route::post('/izin', [IzinController::class, 'store'])->middleware('role:user,admin,verifikator');
        Route::get('/izin', [IzinController::class, 'index']);
        Route::get('/izin/{id}', [IzinController::class, 'show']);
        Route::put('/izin/{id}', [IzinController::class, 'update']);
        Route::put('/izin/{id}/batal', [IzinController::class, 'cancel']);
        Route::delete('/izin/{id}', [IzinController::class, 'destroy']);
        Route::put('/update-password', [IzinController::class, 'updatePassword']);
    });

    //Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users']);
        Route::post('/verifikator', [AdminController::class, 'createVerifikator']);
        Route::put('/user/{id}/role', [AdminController::class, 'changeToVerifikator']);
        Route::put('/reset-password/{id}', [AdminController::class, 'resetPassword']);
        Route::get('/izin', [AdminController::class, 'allIzin']);
    });

    //Verifikator
    Route::middleware('role:verifikator')->prefix('verifikator')->group(function () {
        Route::get('/users', [VerifikatorController::class, 'users']);
        Route::put('/verify-user/{id}', [VerifikatorController::class, 'verifyUser']);
        Route::get('/izin', [VerifikatorController::class, 'izins']);
        Route::put('/izin/{id}/acc', [VerifikatorController::class, 'accIzin']);
        Route::put('/izin/{id}/tolak', [VerifikatorController::class, 'tolakIzin']);
    });
});
