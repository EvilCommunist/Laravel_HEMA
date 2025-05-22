<?php
/*
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login_view'])->name('login');
Route::get('/admin', [App\Http\Controllers\AuthController::class, 'admin'])->name('admin');
Route::post('/registration', [App\Http\Controllers\AuthController::class, 'registration']);
Route::get('/registration', [App\Http\Controllers\AuthController::class, 'registration_view'])->name('registration');
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

Route::controller(App\Http\Controllers\AuthController::class)->group(function() {
    Route::get('/login', 'login_view')->name('login');
    Route::post('/login', 'login');
    Route::get('/registration', 'registration_view')->name('registration');
    Route::post('/registration', 'registration');
    Route::post('/logout', 'logout')->name('logout');
    
    //Route::get('/admin', 'admin')->name('admin')->middleware('auth');
});

Route::middleware('auth')->prefix('admin')->group(function() {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin');
    Route::get('/products/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.products.destroy');
    /*
    Route::post('/products/{id}/quantity', [App\Http\Controllers\AdminController::class, 'updateQuantity'])
         ->name('admin.product.updateQuantity');
    
    Route::resource('products', App\Http\Controllers\GoodController::class)
         ->except(['show'])
         ->names('admin.products');
    
    Route::resource('categories', App\Http\Controllers\CategoryController::class)
         ->except(['show'])
         ->names('admin.categories');*/
});

Route::get('/store', [StoreController::class, 'dashboard'])->name('store');
Route::get('/store/product/{id}', [StoreController::class, 'showProduct'])->name('product.show');
/*
Route::prefix('store')->group(function() {
    Route::get('/', [StoreController::class, 'viewCart'])->name('store');
    Route::post('/update', [StoreController::class, 'updateCart'])->name('cart.update');
    Route::post('/clear', [StoreController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [StoreController::class, 'checkout'])->name('cart.checkout');
});*/