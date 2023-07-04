<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VideosController;
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

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/',       [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users',  [UsersController::class, 'index'])->name('users');
    Route::get('/videos', [VideosController::class, 'index'])->name('videos');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login',  [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
Route::get('/forgot-password',  [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'postForgotPassword'])->name('forgot-password.post');
Route::get('/reset-password',   [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/reset-password',  [AuthController::class, 'postResetPassword'])->name('reset-password.post');
