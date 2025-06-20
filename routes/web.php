<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/dashboard', [HomeController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    
});

Route::middleware(['auth','role:admin,sales person'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index'])->name('index');
    Route::get('/create',[SalesOrderController::class,'create'])->name('create');
    Route::post('/', [SalesOrderController::class, 'store'])->name('store');
    Route::get('/{id}/invoice', [SalesOrderController::class, 'invoice'])->name('invoice');
    Route::get('/orders/{id}/invoice-pdf', [SalesOrderController::class, 'downloadPdf'])->name('invoice.pdf');  
    Route::get('/{id}/confirm', [SalesOrderController::class, 'confirmation'])->name('confirm');  
});

Route::delete('/{order}', [SalesOrderController::class, 'destroy'])->middleware(['auth', 'role:admin'])->name('orders.destroy');

// Route::middleware(['auth','role:sales person'])->prefix('orders')->name('orders.')->group(function () {
//     Route::get('/', [SalesOrderController::class, 'index'])->name('index');
//     Route::get('/create',[SalesOrderController::class,'create'])->name('create');
//     Route::post('/', [SalesOrderController::class, 'store'])->name('store');
//     Route::get('/{id}/invoice', [SalesOrderController::class, 'invoice'])->name('invoice');
//     Route::get('/orders/{id}/invoice-pdf', [SalesOrderController::class, 'downloadPdf'])->name('invoice.pdf');  
//     Route::get('/{id}/confirm', [SalesOrderController::class, 'confirmation'])->name('confirm');  
// });

require __DIR__.'/auth.php';
