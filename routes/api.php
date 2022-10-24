<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('info', [AuthController::class, 'user'])->name('user');
        Route::get('client', [AuthController::class, 'client'])->name('client');
        Route::post('create', [AuthController::class, 'create'])->name('create');
    });
});
Route::group([
    'prefix' => 'storage',
    'middleware' => ['auth:api'],
], function () {
    Route::get('allfile', [FileManagerController::class, 'allfile']);
    Route::post('getfile', [FileManagerController::class, 'getfile']);
    Route::post('upload', [FileManagerController::class, 'upload']);
    Route::post('update/{id}', [FileManagerController::class, 'update']);
    Route::delete('delete/{id}', [FileManagerController::class, 'delete']);
    Route::delete('forcedelete/{id}', [FileManagerController::class, 'forceDelete']);
    Route::get('clear', [FileManagerController::class, 'clear']);
    Route::get('trash', [FileManagerController::class, 'trash']);
    Route::get('restore/{id}', [FileManagerController::class, 'restore']);
});
Route::group([
    'prefix' => 'client/storage',
    'middleware' => ['client:storage'],
], function () {
    Route::get('allfile', [FileManagerController::class, 'allfile']);
    Route::post('getfile', [FileManagerController::class, 'getfile']);
    Route::post('upload', [FileManagerController::class, 'upload']);
    Route::post('update/{id}', [FileManagerController::class, 'update']);
    Route::delete('delete/{id}', [FileManagerController::class, 'delete']);
    Route::delete('forcedelete/{id}', [FileManagerController::class, 'forceDelete']);
    Route::get('clear', [FileManagerController::class, 'clear']);
    Route::get('trash', [FileManagerController::class, 'trash']);
    Route::get('restore/{id}', [FileManagerController::class, 'restore']);
});
