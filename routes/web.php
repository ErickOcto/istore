<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories-detail/{slug}', [CategoryController::class, 'categoriesDetail'])->name('categories-detail');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/details/{slug}', [DetailController::class, 'index'])->name('detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/success', [CartController::class, 'success'])->name('success');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/product', [DashboardProductController::class, 'index'])->name('dashboard-product');
Route::get('/dashboard/product-details/{id}', [DashboardProductController::class, 'detail'])->name('dashboard-product-detail');
Route::get('/dashboard/product/add', [DashboardProductController::class, 'create'])->name('dashboard-product-add');

// Dashboard-transaction
Route::get('/dashboard/transaction', [DashboardTransactionController::class, 'index'])->name('transaction');
Route::get('/dashboard/transaction-detail/{id}', [DashboardTransactionController::class, 'detail'])->name('transaction-detail');
Route::get('/dashboard/setting-store', [DashboardSettingController::class, 'store'])->name('dashboard-setting-store');
Route::get('/dashboard/setting-account', [DashboardSettingController::class, 'account'])->name('dashboard-setting-account');

//Admin Dashboard
Route::prefix('admin')->group( function(){
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('category', AdminCategoryController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class);
});


// Ini default laravel
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dash', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dash');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
