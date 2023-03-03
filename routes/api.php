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
Route::get('check_token', [AuthController::class, 'checkToken'])->middleware('client:storage');
Route::group([
    'prefix' => 'storage',
    'middleware' => ['auth:api'],
], function () {
    Route::group([
        'prefix' => 'file',
    ], function () {
        Route::get('list', [FileManagerController::class, 'list']);
        Route::post('get', [FileManagerController::class, 'get']);
        Route::post('rename', [FileManagerController::class, 'rename']);
        Route::post('move', [FileManagerController::class, 'move']);
        Route::post('upload', [FileManagerController::class, 'upload']);
        Route::post('update/{id}', [FileManagerController::class, 'update']);
        Route::delete('delete/{id}', [FileManagerController::class, 'delete']);
        Route::delete('forcedelete/{id}', [FileManagerController::class, 'forcedelete']);
    });
    Route::group([
        'prefix' => 'folder',
    ], function () {
        Route::get('list', [FileManagerController::class, 'listfolder']);
        Route::post('create', [FileManagerController::class, 'createfolder']);
        Route::post('exist', [FileManagerController::class, 'existfolder']);
        Route::post('rename', [FileManagerController::class, 'renamefolder']);
        Route::post('getfile', [FileManagerController::class, 'getfilefolder']);
        Route::delete('delete', [FileManagerController::class, 'deletefolder']);
    });
    Route::group([
        'prefix' => 'trash',
    ], function () {
        Route::get('list', [FileManagerController::class, 'listtrash']);
        Route::get('clean', [FileManagerController::class, 'clean']);
        Route::delete('delete/{id}', [FileManagerController::class, 'deletetrash']);
        Route::get('restore/{id}', [FileManagerController::class, 'restore']);
    });

});
Route::group([
    'prefix' => 'storage/client',
    'middleware' => ['client:storage'],
], function () {
    Route::group([
        'prefix' => 'file',
    ], function () {
        Route::get('list', [FileManagerController::class, 'list']);
        Route::post('get', [FileManagerController::class, 'get']);
        Route::post('rename', [FileManagerController::class, 'rename']);
        Route::post('move', [FileManagerController::class, 'move']);
        Route::post('upload', [FileManagerController::class, 'upload']);
        Route::post('update/{id}', [FileManagerController::class, 'update']);
        Route::delete('delete/{id}', [FileManagerController::class, 'delete']);
        Route::delete('forcedelete/{id}', [FileManagerController::class, 'forcedelete']);
    });
    Route::group([
        'prefix' => 'folder',
    ], function () {
        Route::get('list', [FileManagerController::class, 'listfolder']);
        Route::post('create', [FileManagerController::class, 'createfolder']);
        Route::post('exist', [FileManagerController::class, 'existfolder']);
        Route::post('rename', [FileManagerController::class, 'renamefolder']);
        Route::post('getfile', [FileManagerController::class, 'getfilefolder']);
        Route::delete('delete', [FileManagerController::class, 'deletefolder']);
    });
    Route::group([
        'prefix' => 'trash',
    ], function () {
        Route::get('list', [FileManagerController::class, 'listtrash']);
        Route::get('clean', [FileManagerController::class, 'clean']);
        Route::delete('delete/{id}', [FileManagerController::class, 'deletetrash']);
        Route::get('restore/{id}', [FileManagerController::class, 'restore']);
    });

});
