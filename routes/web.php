<?php

use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ColorController;
use App\Http\Controllers\backend\CouponControoler;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\InventoryController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\RolePermissionController;
use App\Http\Controllers\backend\ShippingconditionController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\ShopController;
use App\Http\Controllers\frontend\UserorderController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => false]);

//frontend Route S ================
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/categoryPro/{id}', [FrontendController::class, 'categoryPro'])->name('categoryPro.index');
Route::get('/productSrch', [FrontendController::class, 'productSrch'])->name('productSrch.index');

//Frontend Shop Route
Route::controller(ShopController::class)->prefix('frontend/')->name('frontend.')->group(function () {

    Route::get('shop', 'allProduct')->name('shop');
    Route::get('shop/single/{slug}', 'singleProduct')->name('single.shop');
    Route::post('shop/shopColor', 'shopColor')->name('single.shopColor');
    Route::post('shop/single/stock', 'shopStock')->name('single.stock');
});

// SSLCOMMERZ Start
Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::controller(CartController::class)->prefix('frontend/')->name('frontend.')->middleware(['auth'])->group(function () {

    Route::get('cart/index', 'index')->name('cart.index');
    Route::post('cart/store', 'store')->name('cart.store');
    Route::post('cart/update', 'update')->name('cart.update');

    Route::post('cart/couponn/apply', 'applyCoupon')->name('cart.couponn.apply');

    Route::post('cart/select/shipping', 'applyShipping')->name('cart.select.shipping');

    Route::get('checkOut', 'checkOutview')->name('checkOut.view');

    Route::delete('cart/destroy/{cart}', 'destroy')->name('cart.destroy');
});

//User Route
Route::controller(UserorderController::class)->name('user.')->middleware(['auth'])->group(function () {

    Route::get('orders', 'index')->name('orders');
    // Route::get('orders/invoice/{invoice}', 'invoice')->name('orders.invoice');

});

//Dashboard Route
Route::get('backend/home', [DashboardController::class, 'index'])->middleware(['auth'])->name('backend.home');

//Backend Route
Route::group(['middleware' => ['role:super-admin']], function () {

    Route::prefix('backend/')->name('backend.')->middleware(['auth'])->group(function () {

        //Role And Permission Route
        Route::controller(RolePermissionController::class)->middleware(['role:super-admin'])->group(function () {

            //Role Rute
            Route::get('role/index', 'index')->name('role.index');

            Route::get('role/create', 'createRole')->name('role.create');

            Route::post('role/insert', 'insertRole')->name('role.insert');

            Route::get('role/{id}/edit', 'editRole')->name('role.edit');

            Route::post('role/update/{id}', 'updatetRole')->name('role.update');

            Route::delete('role/delete/{id}', 'deleteRole')->name('role.delete');

            //User Rute
            Route::get('role/users', 'users')->name('role.users');

            Route::get('user/{id}/edit', 'editUser')->name('user.edit');

            Route::post('user/update/{id}', 'updatetUser')->name('user.update');

            Route::delete('user/delete/{id}', 'userDelete')->name('user.delete');

            Route::get('user/undo/{id}', 'userUndo')->name('user.undo');

            Route::get('user/destroy/{id}', 'userDestroy')->name('user.destroy');

            //Permission Route
            Route::get('permission/index', 'allPermission')->name('role.permission.index');

            Route::post('permission/insert', 'insertPermission')->name('permission.insert');

            Route::get('permission/{id}/edit', 'editPermission')->name('permission.edit');

            Route::post('permission/update/{id}', 'updatePermission')->name('permission.update');

            Route::get('permission/delete/{id}', 'deletePermission')->name('permission.delete');
        });

        //Category And Product Route
        Route::controller(CategoryController::class)->prefix('product/')->name('product.')->middleware(['permission:add|view|edit|delete'])->group(function () {
            //Product Route
            Route::controller(ProductController::class)->middleware(['permission:add|view|edit|delete'])->group(function () {

                Route::get('index', 'index')->name('index');

                Route::get('show/{id}', 'show')->name('show');

                Route::get('create', 'create')->name('create');

                Route::post('store', 'store')->name('store');

                Route::get('{id}/edit', 'edit')->name('edit');

                Route::put('update/{id}', 'update')->name('update');

                Route::put('updateGall/{id}', 'updateGall')->name('updateGall');

                Route::get('editGallImg/{id}', 'editGallImg')->name('editGallImg');

                Route::put('updateGallImg/{id}', 'updateGallImg')->name('updateGallImg');

                Route::delete('delteGallImg/{id}', 'delteGallImg')->name('delteGallImg');

                Route::delete('softDel/{id}', 'softDel')->name('softDel');

                Route::get('proUndo/{id}', 'proUndo')->name('proUndo');

                Route::get('destroy/{id}', 'destroy')->name('destroy');
            });

            //Inventory Route
            Route::controller(InventoryController::class)->middleware(['permission:add|view|edit|delete'])->group(function () {

                Route::get('inventory/index/{id}', 'index')->name('inventory.index');

                Route::get('inventory/create', 'create')->name('inventory.create');

                Route::post('inventory/store/{id}', 'store')->name('inventory.store');

                Route::get('inventory/{id}/edit', 'edit')->name('inventory.edit');

                Route::put('inventory/update/{id}', 'update')->name('inventory.update');

                Route::post('inventory/size/select', 'sizeSelect')->name('inventory.size.select');

                Route::get('inventory/destroy/{id}', 'destroy')->name('inventory.destroy');
            });

            //Product Color

            Route::controller(ColorController::class)->middleware(['permission:add|view|edit|delete'])->group(function () {

                Route::get('color/index', 'index')->name('color.index');

                Route::get('color/create', 'create')->name('color.create');

                Route::post('color/store', 'store')->name('color.store');

                Route::get('color/{id}/edit', 'edit')->name('color.edit');

                Route::put('color/update/{id}', 'update')->name('color.update');

                Route::delete('color/softDel/{id}', 'softDel')->name('color.softDel');

                Route::get('color/proUndo/{id}', 'Undo')->name('color.Undo');

                Route::get('color/destroy/{id}', 'destroy')->name('color.destroy');
            });

            //Coupon
            Route::controller(CouponControoler::class)->middleware(['permission:add|view|edit|delete'])->group(function () {

                Route::get('coupon/index', 'index')->name('coupon.index');

                Route::post('coupon/store', 'store')->name('coupon.store');

                Route::get('coupon/{coupon}/edit', 'edit')->name('coupon.edit');

                Route::put('coupon/update/{coupon}', 'update')->name('coupon.update');

                Route::get('coupon/destroy/{coupon}', 'destroy')->name('coupon.destroy');
            });

            //Shipping Condition
            Route::controller(ShippingconditionController::class)->middleware(['permission:add|view|edit|delete'])->group(function () {

                Route::get('shipping/index', 'index')->name('shipping.index');

                Route::post('shipping/store', 'store')->name('shipping.store');

                Route::get('shipping/{shippingCondition}/edit', 'edit')->name('shipping.edit');

                Route::put('shipping/update/{shippingCondition}', 'update')->name('shipping.update');

                Route::get('shipping/destroy/{shippingCondition}', 'destroy')->name('shipping.destroy');
            });

            //Category Route

            Route::get('category/index', 'index')->name('category.index');

            Route::get('category/create', 'create')->name('category.create');

            Route::post('category/store', 'store')->name('category.store');

            Route::get('category/show/{id}', 'show')->name('category.show');

            Route::get('category/{id}/edit', 'edit')->name('category.edit');

            Route::put('category/update/{id}', 'update')->name('category.update');

            Route::delete('category/delete/{id}', 'delete')->name('category.delete');

            Route::get('category/undo/{id}', 'categoryUndo')->name('category.categoryUndo');

            Route::get('category/destroy/{id}', 'destroy')->name('category.destroy');
        });

        //Order Route
        Route::controller(OrderController::class)->prefix('backend/')->name('order.')->middleware(['auth'])->group(function () {
            Route::get('order', 'index')->name('index');
            Route::get('order/show/{order}', 'show')->name('show');
            Route::put('order/update/{order}', 'update')->name('update');
        });
    });

});
