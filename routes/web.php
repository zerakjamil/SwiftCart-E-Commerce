<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\User\V1\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\User\V1\UserController;
use App\Http\Controllers\Admin\V1\AdminController;
use App\Http\Controllers\Admin\V1\BrandController;
use App\Http\Controllers\Admin\V1\CategoryController;
use App\Http\Controllers\Admin\V1\ProductController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

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
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
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

        Route::resources([
            'brands' => BrandController::class,
            'products' => ProductController::class,
            'categories' => CategoryController::class,
        ], ['except' => ['show'], 'as' => 'admin']);
    });
});

Route::get('/greeting/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'ar', 'kr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language.switch');
