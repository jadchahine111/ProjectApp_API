<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;



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
Route::get('/user/notifications/{id}', [NotificationsController::class, 'getNotifications']);
Route::get('/categories', [CategoriesController::class, 'index']);


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
    Route::post('/signup', [AuthController::class, 'signup']);  // Sign-up route
    Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');  // Email verification route
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('/accept-registration/{userId}', [AdminController::class, 'acceptUserRegistration']);
    Route::post('/decline-registration/{userId}', [AdminController::class, 'declineUserRegistration']);
});