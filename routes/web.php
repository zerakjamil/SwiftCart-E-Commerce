<?php

use App\Http\Controllers\Admin\V1\AdminController;
use App\Http\Controllers\Admin\V1\BrandController;
use App\Http\Controllers\Admin\V1\CategoryController;
use App\Http\Controllers\Admin\V1\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\V1\HomeController;
use App\Http\Controllers\User\V1\UserController;
use App\Http\Middleware\V1\AuthAdmin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

//route for shop
Route::prefix('shop')->name('shop')->group(function(){
    Route::get('/', [ShopController::class, 'index'])->name('.index');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('.show');
    Route::get('/category/{category}', [ShopController::class, 'category'])->name('.category');
    Route::get('/brand/{brand}', [ShopController::class, 'brand'])->name('.brand');
});
//route for user
Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

//route for admin
Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::resource('/admin/brands',BrandController::class)->names([
        'index' => 'brand.index',
        'create' => 'brand.create',
        'store' => 'brand.store',
        'edit' => 'brand.edit',
        'update' => 'brand.update',
        'destroy' => 'brand.destroy',
    ]);

    Route::resource('/admin/products',ProductController::class)->names([
       'index' => 'product.index',
       'create' => 'product.create',
       'store' => 'product.store',
       'edit' => 'product.edit',
       'update' => 'product.update',
       'destroy' => 'product.destroy',
    ]);

    Route::resource('/admin/categories',CategoryController::class)->names([
        'index' => 'category.index',
        'create' => 'category.create',
        'store' => 'category.store',
        'edit' => 'category.edit',
        'update' => 'category.update',
        'destroy' => 'category.destroy',
    ]);
});

//route for language switch
Route::get('/greeting/{locale}', function(string $locale){
    if (!in_array($locale, ['en', 'ar', 'kr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language.switch');
