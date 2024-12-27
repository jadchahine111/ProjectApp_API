api.php

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UserProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;




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

Route::prefix('user')->middleware('auth:sanctum:user')->group(function () {

    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/update/{id}', [UserController::class, 'updateUserDetails']);
    
    // Notification APIs
    Route::get('/notifications/{id}', [NotificationsController::class, 'getNotifications']);

    // Categories APIs
    Route::get('/categories', [CategoriesController::class, 'index']);
});

Route::prefix('admin')->middleware('auth:sanctum:admin')->group(function () {
    Route::post('/accept-registration/{userId}', [AdminController::class, 'acceptUserRegistration']);
    Route::post('/decline-registration/{userId}', [AdminController::class, 'declineUserRegistration']);
Route::get('/user/applied-projects/{userId}', [UserProjectController::class, 'getAppliedProjects']);
Route::get('/user/notifications/{id}', [NotificationsController::class, 'getNotifications']);
Route::get('/categories', [CategoriesController::class, 'index']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
    Route::post('/signup', [AuthController::class, 'signup']);  // Sign-up route
    Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');  // Email verification route
});