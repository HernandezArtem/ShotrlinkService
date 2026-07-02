<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotFoundController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/links', [HomeController::class, 'store'])
    ->middleware(['auth', 'throttle:link-creation'])
    ->name('links.store');

Route::get('/{code}', RedirectController::class)
    ->middleware('throttle:link-redirect')
    ->where('code', '[A-Za-z0-9]{6}')
    ->name('redirect');

Route::fallback(NotFoundController::class);
