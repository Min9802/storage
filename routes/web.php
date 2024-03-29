<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth:api');
// Route::get('login', [AuthController::class, 'login'])->name('login');
// Route::get('test', [HomeController::class, 'test'])->name('test')->middleware('auth:api');

Route::get('test', [TestController::class, 'test']);
Route::get('url', [TestController::class, 'url']);
Route::get('download', [TestController::class, 'download'])->name('download');
Route::view('/{path?}', 'layouts.app');
