<?php

use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/visit', [VisitController::class, 'visit'])->name('api.visit');

Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/loggedin', [LoginController::class, 'loggedin'])->name('api.loggedin');
    Route::get('/users', [UsersController::class, 'index'])->name('api.users');
});
