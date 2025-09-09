<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'user', 'middleware' => 'userMiddleware'], function(){
    Route::get('home', [UserController::class, 'home'])->name('user#home');

    Route::get('editProfile', [ProfileController::class,'editProfile'])->name('user#editProfile');
    Route::post('updateProfile', [ProfileController::class,'updateProfile'])->name('user#updateProfile');
    Route::get('changePasswordPage', [ProfileController::class,'changePasswordPage'])->name('user#changePasswordPage');
    Route::post('changePassword', [ProfileController::class,'changePassword'])->name('user#changePassword');

    //wishlist
    Route::post('wishList', [UserController::class,'wishList'])->name('user#wishList');
    Route::get('viewWishList', [UserController::class,'viewWishList'])->name('user#viewWishList');

    //product details
    Route::get('detailProduct/{id}', [UserController::class,'detailProduct'])->name('user#detailProduct');
});
