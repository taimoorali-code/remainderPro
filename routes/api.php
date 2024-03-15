<?php

use App\Http\Controllers\FollowupController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/followup', [FollowupController::class, 'store']);
Route::post('/filterfollowup', [FollowupController::class, 'filterFollowups']); // Get all follow-ups

    Route::get('/followup', [FollowupController::class, 'index']); // Get all follow-ups
    Route::get('/followup/show/{userId}', [FollowupController::class, 'show']); // Get a specific follow-up
    Route::post('/followup/create', [FollowupController::class, 'store']); // Create a new follow-up
    Route::put('/followup/update/{id}', [FollowupController::class, 'update']); // Update a follow-up
    Route::delete('/followup/delete/{id}', [FollowupController::class, 'destroy']); // Delete a follow-up
           
// Route::post('followups', FollowupController::class);
