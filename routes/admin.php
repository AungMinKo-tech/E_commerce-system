<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin#dashboard');

    //Category
    Route::group(['prefix' => 'category'], function () {
            Route::get('list', [CategoryController::class, 'listCategory'])->name('admin#category');
            Route::post('create', [CategoryController::class, 'categoryCreate'])->name('admin#categoryCreate');
            Route::get('edit/{id}', [CategoryController::class, 'editCategory'])->name('admin#categoryEdit');
            Route::post('update/{id}', [CategoryController::class, 'updateCategory'])->name('admin#categoryUpdate');
            Route::get('delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin#categoryDelete');
        });

    Route::group(['prefix' => 'product'], function () {
        Route::get('list/{action?}', [ProductController::class,'listProduct'])->name('admin#productList');
        Route::get('addProductPage', [ProductController::class, 'addProductPage'])->name('admin#addProductPage');
        Route::post('createProduct', [ProductController::class,'createProduct'])->name('admin#createProduct');
        Route::post('deleteProduct', [ProductController::class,'deleteProduct'])->name('admin#deleteProduct');
        Route::get('editProduct/{id}', [ProductController::class,'editProduct'])->name('admin#editProduct');
        Route::post('updateProduct', [ProductController::class,'updateProduct'])->name('admin#updateProduct');
        Route::get('details/{id}', [ProductController::class,'detailsProduct'])->name('admin#detailsProduct');
    });

    Route::group(['prefix'=> 'color'], function () {
        Route::get('addColor', [AdminController::class,'addColor'])->name('admin#addColor');
        Route::post('createColor', [AdminController::class, 'createColor'])->name('admin#createColor');
        Route::get('delete/{id}', [AdminController::class,'deleteColor'])->name('admin#deleteColor');
    });

    Route::group(['prefix'=> 'profile'], function () {
        Route::get('changePassword', [ProfileController::class,'changePassword'])->name('admin#changePassword');
        Route::post('updatePassword', [ProfileController::class,'updatePassword'])->name('admin#updatePassword');
        Route::get('viewProfile', [ProfileController::class,'view'])->name('admin#viewProfile');
        Route::get('editProfile', [ProfileController::class,'editProfile'])->name('admin#editProfile');
        Route::post('updateProfile', [ProfileController::class,'updateProfile'])->name('admin#updateProfile');
    });

    Route::get('adminList', [AdminController::class,'adminList'])->name('admin#adminList');
    Route::get('adminDetails/{id}', [AdminController::class,'adminDetails'])->name('admin#adminDetails');
    Route::get('deliveryDetails/{id}', [AdminController::class,'deliveryDetails'])->name('admin#deliveryDetails');

    Route::group(['middleware'=> 'ownerMiddleware'], function () {
        Route::get('newAdminPage', [AdminController::class,'newAdminPage'])->name('admin#newAdminPage');
        Route::post('newAdmin', [AdminController::class,'newAdmin'])->name('admin#newAdmin');
        Route::get('newDeliveryPage', [AdminController::class,'newDeliveryPage'])->name('admin#newDeliveryPage');
        Route::post('newDelivery', [AdminController::class,'newDelivery'])->name('admin#newDelivery');
        Route::post('adminDelete', [AdminController::class,'adminDelete'])->name('admin#delete');
    });
});
