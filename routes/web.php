<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';

// Smart root route that redirects based on authentication and role
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner' || Auth::user()->role == 'delivery') {
            return redirect()->route('admin#dashboard');
        } else {
            return redirect()->route('user#home');
        }
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Social Login
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('socialLogin');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('socialCallback');

require __DIR__.'/auth.php';
