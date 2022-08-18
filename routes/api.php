<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Api\Controllers\CommentController;
use Api\Controllers\SignupController;

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

// protected apis
Route::middleware(['auth:api', 'ajax_only'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/users/{user}')->group(function () {
        Route::resource('comments', CommentController::class);
    });
});

// protected apis
Route::middleware('ajax_only')->group(function () {
    // signup
    Route::prefix('/signup')->group(function () {
        Route::get('/check_email/{email}', [SignupController::class, 'checkEmail']);
        Route::post('', [SignupController::class, 'store']);
    });
});
