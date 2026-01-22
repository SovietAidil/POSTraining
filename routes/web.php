<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoodsIssuanceController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login',[LoginController::class,'handleLogin'])->name('login');


Route::middleware('auth')->group(function () {
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
        Route::post('/logout',[LoginController::class,'logout'])->name('logout');

        Route::prefix('get-data')->as('get-data.')->group(function () {
            Route::get('/product',[ProductController::class, 'getData'])->name('product');
            Route::get('check-stock-product',[ProductController::class, 'checkStock'])->name('check-stock');
            Route::get('check-product-price',[ProductController::class, 'checkPrice'])->name('check-price');
        });

        Route::prefix('users')->as('users.')->controller(UserController::class)->group(function () {
         Route::get('/', 'index')->name('index');
         Route::post('/', 'store')->name('store');
         Route::delete('/{id}/destroy','destroy')->name('destroy');
         Route::post('/change-password','changePassword')->name('change-password');
         Route::post('/reset-password','resetPassword')->name('reset-password');
        });
        // master-data.category.index
        // master-data/category/index

        Route::prefix('master-data')->as('master-data.')->group(function () {
            Route::prefix('category')->as('category.')->controller(CategoryController::class)->group(function()
            {
                Route::get('/','index')->name('index');
                Route::post('/','store')->name('store');
                Route::delete('/{id}/destroy', 'destroy')->name('destroy');
            });
            Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/','store')->name('store');
                Route::delete('/{id}/destroy', 'destroy')->name('destroy');
            });
        });

        Route::prefix('goods-receipt')->as('goods-receipt.')->controller(GoodsReceiptController::class)->group(function
            (){
            Route::get('/','index')->name('index');
            Route::post('/','store')->name('store');
        });

         Route::prefix('goods-issuance')->as('goods-issuance.')->controller(GoodsIssuanceController::class)->group(function
            (){
            Route::get('/','index')->name('index');
            Route::post('/','store')->name('store');
        });

        Route::prefix('report')->as('report.')->group(function(){
            Route::prefix('goods-receipt')->as('goods-receipt.')->controller(GoodsReceiptController::class)->group
            (function(){
                Route::get('/report','report')->name('report');
                Route::get('/report/{receipt_number}/detail','detailReport')->name('detail-report');
            });
             Route::prefix('goods-issuance')->as('goods-issuance.')->controller(GoodsIssuanceController::class)->group
            (function(){
                Route::get('/report',action: 'report')->name('report');
                Route::get('/report/{issuance_number}/detail','detailReport')->name('detail-report');
            });
        });


    });

