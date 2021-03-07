<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;


Route::get('/', function () {
    return redirect('/register');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/home', [OpinionController::class, 'index'])->name('home');
    Route::get('/explore/{search?}', [UserController::class, 'index'])->name('explore');
    Route::prefix('notifications')->group(function () {
        Route::get('/', [UserNotificationController::class, 'index'])->name('notifications');
        Route::delete('/{notifications:id}/delete', [UserNotificationController::class, 'destroy'])->name('notifications.delete');
    });

    Route::get('/mention/{search?}', [UserController::class, 'mention'])->name('mention');

    Route::prefix('user')->group(function () {
        Route::get('/{user:username}', [UserController::class, 'show'])->name('user');
        Route::get('/{user:username}/following', [UserController::class, 'following'])->name('user.following');
        Route::get('/{user:username}/followers', [UserController::class, 'followers'])->name('user.followers');
        Route::post('/{user:username}/follow', [UserController::class, 'follow'])->name('user.follow');
    });

    Route::prefix('opinion')->group(function () {
        Route::post('/', [OpinionController::class, 'store'])->name('opinion.store');
        Route::get('/{opinion}', [OpinionController::class, 'show'])->name('opinion');
        Route::post('/{opinion}/like', [OpinionController::class, 'like'])->name('opinion.like');
        Route::delete('/{opinion}/delete', [OpinionController::class, 'destroy'])->name('opinion.delete');
    });
});
