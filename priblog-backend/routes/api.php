<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
});

Route::prefix('blogs')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('', [BlogController::class, 'index'])
            ->name('index');

        Route::post('', [BlogController::class, 'store'])
            ->name('store');

        Route::get('{blogId}', [BlogController::class, 'show'])
            ->name('show')
            ->whereNumber('blogId');

        Route::put('{blogId}', [BlogController::class, 'update'])
            ->name('update')
            ->whereNumber('blogId');

        Route::delete('{blogId}', [BlogController::class, 'destroy'])
            ->name('destroy')
            ->whereNumber('blogId');
    });

Route::prefix('comments')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('', [CommentController::class, 'index'])
            ->name('index');

        Route::post('', [CommentController::class, 'store'])
            ->name('store');

        Route::get('{commentId}', [CommentController::class, 'show'])
            ->name('show')
            ->whereNumber('commentId');

        Route::put('{commentId}', [CommentController::class, 'update'])
            ->name('update')
            ->whereNumber('commentId');

        Route::delete('{commentId}', [CommentController::class, 'destroy'])
            ->name('destroy')
            ->whereNumber('commentId');
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
