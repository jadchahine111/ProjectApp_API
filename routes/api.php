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

Route::post('/signup', [AuthController::class, 'signUp']);


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/info', [UserController::class, 'getUserDetailsById']);
    Route::get('/{id}', [UserController::class, 'getOtherUserDetailsById']);
    Route::put('/update', [UserController::class, 'updateUserDetails']);
    Route::put('/user-projects/apply/{projectId}', [UserProjectController::class, 'apply']);
    Route::put('/user-projects/reject/{userId}', [UserProjectController::class, 'reject']);
    Route::put('/projects/unarchive/{projectId}', [UserProjectController::class, 'unarchiveProject']);
    Route::put('/projects/archive/{projectId}', [UserProjectController::class, 'archiveProject']);
    Route::delete('/projects/delete/{projectId}', [UserProjectController::class, 'deleteProject']);
    Route::post('/add-project', [UserProjectController::class, 'postAProject']);
    Route::post('/add-fav/{projectId}', [UserProjectController::class, 'addProjectToFav']);
    Route::delete('/remove-fav/{projectId}', [UserProjectController::class, 'remProjectFromFav']);
    Route::get('/projects/recent-active', [ProjectController::class, 'getRecentActiveProjects']); 
    Route::put('/projects/update/{projectId}', [ProjectController::class, 'updateProject']); 
});

Route::prefix('projects')->middleware('auth:sanctum')->group(function () {
    Route::get('/active-projects', [UserProjectController::class, 'getUserActiveProjects']);
    Route::get('/{id}', [ProjectController::class, 'getProjectById']);
    Route::get('/{projectId}/applied-users', [UserProjectController::class, 'getAppliedUsersForProject']);
    Route::put('/{projectId}/accept-applicant/{userId}', [UserProjectController::class, 'acceptProjectApplicant']);
    Route::put('/{projectId}/decline-applicant/{userId}', [UserProjectController::class, 'declineProjectApplicant']);
});


Route::prefix('status')->middleware('auth:sanctum')->group(function () {
    Route::get('/accepted-projects', [UserProjectController::class, 'getAcceptedProjects']);
    Route::get('/archived-projects', [UserProjectController::class, 'getUserArchivedProjects']);
    Route::get('/favorited-projects', [UserProjectController::class, 'getFavoritedProjects']);
    Route::get('/applied-projects', [UserProjectController::class, 'getAppliedProjects']);
    Route::get('/rejected-projects', [UserProjectController::class, 'getRejectedProjects']);
    Route::get('/favorited-projects', [UserProjectController::class, 'getFavoritedProjects']);  
});




Route::prefix('categories')->middleware('auth:sanctum')->group(function () {
    Route::get('/all', [CategoriesController::class, 'getAllCategories']); // Categories route here
});

Route::prefix('notifications')->middleware('auth:sanctum')->group(function () {
    Route::get('/all', [NotificationsController::class, 'getNotifications']);
    Route::delete('/delete/{notificationId}', [NotificationsController::class, 'deleteNotification']);
});


Route::prefix('admin')->middleware('auth:admin-api')->group(function () {
    Route::post('/accept-registration/{userId}', [AdminController::class, 'acceptUserRegistration']);
    Route::post('/decline-registration/{userId}', [AdminController::class, 'declineUserRegistration']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');  // Email verification route
    Route::get('/check-verification-status', [AuthController::class, 'checkVerificationStatus']);

});