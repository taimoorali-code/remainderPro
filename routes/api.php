<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'logout'])
                ->name('logout');
});


//AUth
Route::post('email/verify/{id}', [VerificationController::class, 'verify'])
    ->name('verification.verify');


Route::post('/forgotpassword', [PasswordResetController::class, 'send_reset_password_email']); // Get all follow-ups
Route::post('/verifypassword', [PasswordResetController::class, 'reset']); // Get all follow-ups
Route::post('/resetpassword', [PasswordResetController::class, 'resetPassword']); // Get all follow-ups




//Feedbacks
Route::post('/storeFeedbacks', [FeedbackController::class, 'store']); // Get all follow-ups

// get user details
Route::post('/getUserInfo/{userId}', [UserController::class, 'filterFollowups']); // Get all follow-ups
Route::get('/users/{id}', [UserController::class, 'getUserById']);
Route::put('/users/{id}', [UserController::class, 'update']); // Update user information
Route::post('/uploadprofileimage/{id}', [UserController::class, 'uploadProfileImage']); // Upload profile image



// Route::post('/followup', [FollowupController::class, 'store']);
    Route::post('/filterfollowup/{userId}', [FollowupController::class, 'filterFollowups']); // Get all follow-ups
    Route::get('/followups/done/{userId}', [FollowupController::class, 'doneFollowups']);
    Route::get('/followups/deleted/{userId}', [FollowupController::class, 'deletedFollowups']);
    Route::get('/followup', [FollowupController::class, 'index']); // Get all follow-ups
    Route::get('/followup/show/{userId}', [FollowupController::class, 'show']); // Get a specific follow-up
    Route::get('/followup/search/{userId}', [FollowupController::class, 'search']);
    Route::post('/followup/create', [FollowupController::class, 'store']); // Create a new follow-up
    Route::put('/followup/update/{id}', [FollowupController::class, 'update']); // Update a follow-up
    Route::delete('/followup/delete/{id}', [FollowupController::class, 'destroy']); // Delete a follow-up

    Route::get('followup/{id}/history', [FollowupController::class, 'followupHistory']); // Delete a follow-up

           
// Route::post('followups', FollowupController::class);

Route::post('/social-login', 'App\Http\Controllers\SocialAuthController@social_customer_login');

