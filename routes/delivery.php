<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;

Route::group(['prefix' => 'delivery', 'middleware' => ['deliveryMiddleware']], function () {
    Route::get('deliveryHome', [DeliveryController::class, 'home'])->name('delivery#home');
    Route::post('completeDelivery', [DeliveryController::class, 'completeDelivery'])->name('delivery#complete');
    Route::get('delivery/viewDelivered', [DeliveryController::class, 'viewDelivered'])->name('delivery#delivered');
});

