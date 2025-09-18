<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;

Route::group(['prefix' => 'delivery', 'middleware'=> ['deliveryMiddleware']], function () {
    Route::get('deliveryHome',[DeliveryController::class,'home'])->name('delivery#home');
    Route::post('start/{id}',[DeliveryController::class,'startDelivery'])->name('delivery#start');
    Route::post('complete/{id}',[DeliveryController::class,'completeDelivery'])->name('delivery#complete');
    Route::get('details/{id}',[DeliveryController::class,'getDeliveryDetails'])->name('delivery#details');
});
