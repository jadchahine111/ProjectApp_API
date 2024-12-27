<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UserProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;



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

Route::prefix('user')->middleware('auth:sanctum')->group(function () {

    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/update/{id}', [UserController::class, 'updateUserDetails']);
    
    // Notification APIs
    Route::get('/notifications/{id}', [NotificationsController::class, 'getNotifications']);

    // Categories APIs
    Route::get('/categories', [CategoriesController::class, 'index']);

    Route::get('/applied-projects/{userId}', [UserProjectController::class, 'getAppliedProjects']);
    Route::get('/favorited-projects/{userId}', [UserProjectController::class, 'getFavoritedProjects']);
    Route::get('/rejected-projects/{userId}', [UserProjectController::class, 'getRejectedProjects']);
    Route::put('/user-projects/apply/{id}', [UserProjectController::class, 'apply']);
    Route::put('/user-projects/reject/{id}', [UserProjectController::class, 'reject']);
    Route::put('/projects/unarchive/{projectId}', [UserProjectController::class, 'unarchiveProject']);
    Route::put('/projects/archive/{projectId}', [UserProjectController::class, 'archiveProject']);
    Route::delete('/projects/delete/{projectId}', [UserProjectController::class, 'deleteProject']);

    // Project APIs
    Route::get('/projects/recent-active', [ProjectController::class, 'getRecentActiveProjects']); // Get recent active projects
    Route::put('/projects/update/{id}', [ProjectController::class, 'updateProject']); // Update project details
});

Route::prefix('admin')->middleware('auth:admin-api')->group(function () {
    Route::post('/accept-registration/{userId}', [AdminController::class, 'acceptUserRegistration']);
    Route::post('/decline-registration/{userId}', [AdminController::class, 'declineUserRegistration']);
});


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
    Route::post('/signup', [AuthController::class, 'signup']);  // Sign-up route
    Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');  // Email verification route
});