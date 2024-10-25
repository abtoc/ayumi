<?php

use App\Http\Controllers\Api\ClientControler;
use App\Http\Controllers\Api\LiverController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ScreenshotController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/logout', [LogoutController::class, 'logout'])->name('api.logout');
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/visit', [VisitController::class, 'visit'])->name('api.visit');
    Route::get('/livers', [LiverController::class, 'index'])->name('api.livers');
    Route::get('/screenshot', [ScreenshotController::class,'index'])->name('api.screenshort.index');
    Route::get('/screenshot/show', [ScreenshotController::class, 'show'])->name('api.screenshot.show');
    Route::post('/screenshot/upload', [ScreenshotController::class, 'upload'])->name('api.screenshot.upload');
    Route::delete('/screenshot/{screenshot}', [ScreenshotController::class, 'delete'])->name('api.screenshot.delete');
    Route::get('/clients', [ClientControler::class, 'client'])->name('api.clients.clients');
    Route::get('/events/{client_event}', [ClientControler::class, 'event'])->name('api.clients.events');
    Route::put('/toggle/{id}', [ClientControler::class,'toggle'])->name('api.clients.toggle');
    Route::get('/loggedin', [LoginController::class, 'loggedin'])->name('api.loggedin');
});
