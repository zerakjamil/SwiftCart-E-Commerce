<?php

use App\Http\Controllers\AdminController;
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
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brands/create', [AdminController::class, 'createBrand'])->name('admin.create-brand');
    Route::post('/admin/brands/store', [AdminController::class, 'storeBrand'])->name('admin.store-brand');
    Route::get('/admin/brands/edit/{brand}', [AdminController::class, 'editBrand'])->name('admin.edit-brand');
    Route::put('/admin/brands/update/{brand}', [AdminController::class, 'updateBrand'])->name('admin.update-brand');
    Route::delete('/admin/brands/delete/{brand}', [AdminController::class, 'deleteBrand'])->name('admin.delete-brand');
});

Route::get('/greeting/{locale}', function(string $locale){
    if (!in_array($locale, ['en', 'ar', 'kr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language.switch');
