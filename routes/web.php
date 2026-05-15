<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', [CustomerOrderController::class, 'startOrder']);

Route::get('/order', [CustomerOrderController::class, 'startOrder']);
Route::post('/order/start', [CustomerOrderController::class, 'saveOrderType']);
Route::get('/order/menu', [CustomerOrderController::class, 'index']);

Route::post('/cart/add/{id}', [CustomerOrderController::class, 'addToCart']);
Route::post('/cart/minus/{id}', [CustomerOrderController::class, 'minusCart']);
Route::post('/cart/remove/{id}', [CustomerOrderController::class, 'removeCart']);
Route::post('/cart/update/{id}', [CustomerOrderController::class, 'updateCart']);

Route::post('/checkout-page', [CustomerOrderController::class, 'saveCustomerName']);
Route::get('/checkout', [CustomerOrderController::class, 'checkoutPage']);
Route::post('/checkout', [CustomerOrderController::class, 'checkout']);

Route::get('/invoice/{order}', [CustomerOrderController::class, 'invoice']);
Route::get('/payment/{order}', [CustomerOrderController::class, 'payment']);
Route::post('/payment/{order}/confirm', [CustomerOrderController::class, 'confirmPayment']);
Route::get('/payment/{order}/success',
    [CustomerOrderController::class, 'paymentSuccess']);
/*
|--------------------------------------------------------------------------
| ADMIN / OWNER / KASIR / DAPUR ROUTE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | OWNER & ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:owner,admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', CategoryController::class);

        Route::resource('menus', MenuController::class);

        Route::resource('tables', RestaurantTableController::class);

        Route::get('/reports', [ReportController::class, 'index']);
        Route::post('/reports/generate', [ReportController::class, 'generate']);
        Route::get('/reports/pdf', [ReportController::class, 'pdf']);
        Route::get('/reports/excel', [ReportController::class, 'excel']);

        Route::delete('/orders/{order}', [KasirController::class, 'destroyOrder']);

        Route::resource('users', UserManagementController::class);

        Route::get('/kasir/payment/{order}',
    [KasirController::class, 'paymentPage']);

        Route::post('/kasir/payment/{order}',
            [KasirController::class, 'processPayment']);

            Route::get('/kasir/qris/{order}',
            [KasirController::class, 'showQrisPage']);

        Route::post('/kasir/qris/{order}/confirm',
            [KasirController::class, 'confirmQrisPayment']);
                
            });

    /*
    |--------------------------------------------------------------------------
    | KASIR ACCESS
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:owner,admin,kasir'])->group(function () {

        Route::get('/kasir/orders', [KasirController::class, 'index']);

        Route::put('/kasir/orders/{order}/status', [KasirController::class, 'updateStatus']);

        Route::put('/kasir/orders/{order}/payment', [KasirController::class, 'updatePayment']);

        Route::get('/kasir/dashboard',[KasirController::class, 'dashboard']);

        Route::get('/kasir/manual-order', [KasirController::class, 'manualOrder']);
                   

        Route::post('/kasir/manual-order', [KasirController::class, 'storeManualOrder']);

        Route::post('/kasir/manual-order/checkout',
    [KasirController::class, 'storeManualOrder']);

            Route::get('/kasir/payment/{order}',
    [KasirController::class, 'paymentPage']);

Route::post('/kasir/payment/{order}',
    [KasirController::class, 'processPayment']);

    Route::get('/kasir/qris/{order}',
    [KasirController::class, 'showQrisPage']);

Route::post('/kasir/qris/{order}/confirm',
    [KasirController::class, 'confirmQrisPayment']);

            });
           
                                        

    /*
    |--------------------------------------------------------------------------
    | DAPUR ACCESS
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:owner,admin,dapur'])->group(function () {

        Route::get('/kitchen', [KasirController::class, 'kitchen']);

        Route::put('/kitchen/{order}/done', [KasirController::class, 'done']);

        Route::put('/kitchen/{order}/process',
    [KasirController::class, 'process']);

        Route::resource('menus', MenuController::class);
    });
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';