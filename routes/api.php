<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FolderController;
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
Route::get('check_token', [AuthController::class, 'checkToken'])->middleware('client:storage');
Route::group([
    'prefix' => 'storage',
    'middleware' => ['auth:api'],
], function () {
    Route::group([
        'prefix' => 'file',
    ], function () {
        Route::get('list', [FileController::class, 'list']);
        Route::post('get', [FileController::class, 'get']);
        Route::post('rename', [FileController::class, 'rename']);
        Route::post('move', [FileController::class, 'move']);
        Route::post('upload', [FileController::class, 'upload']);
        Route::post('update/{id}', [FileController::class, 'update']);
        Route::delete('delete/{id}', [FileController::class, 'delete']);
        Route::delete('forcedelete/{id}', [FileManagerController::class, 'forcedelete']);
    });
    Route::group([
        'prefix' => 'trash',
    ], function () {
        Route::get('list', [FileController::class, 'listtrash']);
        Route::get('clean', [FileController::class, 'clean']);
        Route::delete('delete/{id}', [FileController::class, 'deletetrash']);
        Route::get('restore/{id}', [FileController::class, 'restore']);
    });
    Route::group([
        'prefix' => 'folder',
    ], function () {
        Route::get('list', [FolderController::class, 'list']);
        Route::post('create', [FolderController::class, 'create']);
        Route::post('exist', [FolderController::class, 'exist']);
        Route::post('rename', [FolderController::class, 'rename']);
        Route::post('getfile', [FolderController::class, 'getfile']);
        Route::delete('delete', [FolderController::class, 'delete']);
    });

});
Route::group([
    'prefix' => 'storage/client',
    'middleware' => ['client:storage'],
], function () {
    Route::group([
        'prefix' => 'file',
    ], function () {
        Route::get('list', [FileController::class, 'list']);
        Route::post('get', [FileController::class, 'get']);
        Route::post('rename', [FileController::class, 'rename']);
        Route::post('move', [FileController::class, 'move']);
        Route::post('upload', [FileController::class, 'upload']);
        Route::post('update/{id}', [FileController::class, 'update']);
        Route::delete('delete/{id}', [FileController::class, 'delete']);
        Route::delete('forcedelete/{id}', [FileController::class, 'forcedelete']);
    });
    Route::group([
        'prefix' => 'trash',
    ], function () {
        Route::get('list', [FileController::class, 'listtrash']);
        Route::get('clean', [FileController::class, 'clean']);
        Route::delete('delete/{id}', [FileController::class, 'deletetrash']);
        Route::get('restore/{id}', [FileController::class, 'restore']);
    });

    Route::group([
        'prefix' => 'folder',
    ], function () {
        Route::get('list', [FolderController::class, 'list']);
        Route::post('create', [FolderController::class, 'create']);
        Route::post('exist', [FolderController::class, 'exist']);
        Route::post('rename', [FolderController::class, 'rename']);
        Route::post('getfile', [FolderController::class, 'getfile']);
        Route::delete('delete', [FolderController::class, 'delete']);
    });

});
