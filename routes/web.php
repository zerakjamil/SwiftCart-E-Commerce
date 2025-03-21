<?php

use App\Http\Controllers\{
    Admin\V1\AdminController,
    Admin\V1\BrandController,
    Admin\V1\CategoryController,
    Admin\V1\CouponController,
    Admin\V1\OrderController,
    Admin\V1\ProductController,
    CartController,
    CheckoutController,
    HomeController,
    ShopController,
    SlideController,
    User\V1\UserController,
    WishlistController
};
use Illuminate\Support\Facades\{App, Auth, Route};

Auth::routes();

Route::get('/', HomeController::class)->name('home.index');

Route::name('shop.')->prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('show');
    Route::get('/category/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/brand/{brand}', [ShopController::class, 'brand'])->name('brand');
});

Route::name('cart.')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'add'])->name('add');
    Route::put('/increment/{rowId}', [CartController::class, 'increment'])->name('increment');
    Route::put('/decrement/{rowId}', [CartController::class, 'decrement'])->name('decrement');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::name('wishlist.')->prefix('wishlist')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{rowId}', [WishlistController::class, 'removeItemFromWishlist'])->name('remove');
    Route::delete('/clear', [WishlistController::class, 'clearWishlist'])->name('clear');
    Route::post('/move-to-cart/{rowId}', [WishlistController::class, 'moveToCart'])->name('moveToCart');
});

Route::prefix('checkout')->name('checkout.')->middleware(['auth'])->group(function (){
   Route::get('/', [CheckoutController::class, 'index'])->name('index');
   Route::post('/place-order', [CheckoutController::class,'store'])->name('store');
   Route::get('/confirmation/{order}', [CheckoutController::class, 'orderConfirmation'])->name('orderConfirmation');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-orders/{order}/details', [UserController::class, 'orderDetail'])->name('user.orders.details');
    Route::put('/account-order/cancel-order', [OrderController::class, 'cancelOrder'])->name('order.cancel');
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth.admin')->group(function () {
        Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');

        Route::middleware('isSuperAdmin')->group(function () {
            Route::resource('admins', AdminController::class)->except(['show'])->names([
                'index' => 'admin.index',
                'create' => 'admin.create',
                'store' => 'admin.store',
                'edit' => 'admin.edit',
                'update' => 'admin.update',
                'destroy' => 'admin.destroy',
            ]);
        });

        Route::prefix('orders')->name('order.')->controller(OrderController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::get('/invoice/{order}', [OrderController::class, 'generateInvoice'])->name('invoice');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        });

        Route::resource('/brands', BrandController::class)->names([
            'index' => 'brand.index',
            'create' => 'brand.create',
            'store' => 'brand.store',
            'edit' => 'brand.edit',
            'update' => 'brand.update',
            'destroy' => 'brand.destroy',
        ]);

        Route::resource('/products', ProductController::class)->names([
            'index' => 'product.index',
            'create' => 'product.create',
            'store' => 'product.store',
            'edit' => 'product.edit',
            'update' => 'product.update',
            'destroy' => 'product.destroy',
        ]);

        Route::resource('/categories', CategoryController::class)->names([
            'index' => 'category.index',
            'create' => 'category.create',
            'store' => 'category.store',
            'edit' => 'category.edit',
            'update' => 'category.update',
            'destroy' => 'category.destroy',
        ]);

        Route::resource('/coupons', CouponController::class)->names([
            'index' => 'coupon.index',
            'create' => 'coupon.create',
            'store' => 'coupon.store',
            'edit' => 'coupon.edit',
            'update' => 'coupon.update',
            'destroy' => 'coupon.destroy',
        ]);

        Route::resource('/slides', SlideController::class)->names([
            'index' => 'slide.index',
            'create' => 'slide.create',
            'store' => 'slide.store',
            'edit' => 'slide.edit',
            'update' => 'slide.update',
            'destroy' => 'slide.destroy',
        ]);

        Route::post('/coupons/apply', [CartController::class, 'applyCouponCode'])->name('coupon.apply');
        Route::post('/coupons/remove', [CartController::class, 'removeCouponCode'])->name('coupon.remove');
    });
});

Route::get('/greeting/{locale}', function(string $locale){
    if (!in_array($locale, ['en', 'ar', 'kr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language.switch');
