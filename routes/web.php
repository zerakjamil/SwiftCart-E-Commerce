<?php

use App\Http\Controllers\Admin\V1\BrandController;
use App\Http\Controllers\Admin\V1\CategoryController;
use App\Http\Controllers\Admin\V1\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\V1\HomeController;
use App\Http\Controllers\User\V1\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\V1\AdminController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::prefix('shop')->name('shop.')->group(function(){
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('show');
    Route::get('/category/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/brand/{brand}', [ShopController::class, 'brand'])->name('brand');
});

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'add'])->name('add');
    Route::put('/increment/{rowId}', [CartController::class, 'increment'])->name('increment');
    Route::put('/decrement/{rowId}', [CartController::class, 'decrement'])->name('decrement');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});



Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::prefix('admin')->group(function(){

    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'auth.admin'], function(){
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

                Route::resource('admins', AdminController::class)->names([
                    'index' => 'admin.index',
                    'create' => 'admin.create',
                    'store' => 'admin.store',
                    'edit' => 'admin.edit',
                    'update' => 'admin.update',
                    'destroy' => 'admin.destroy',
                ]);

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
