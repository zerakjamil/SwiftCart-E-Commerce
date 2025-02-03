<?php

use App\Http\Controllers\Admin\V1\AdminController;
use App\Http\Controllers\Admin\V1\BrandController;
use App\Http\Controllers\Admin\V1\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

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
});

Route::get('/greeting/{locale}', function(string $locale){
    if (!in_array($locale, ['en', 'ar', 'kr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language.switch');
