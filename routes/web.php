<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard', ['title' => 'Dashboard']);
// });

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index')->middleware('role:Waiter,Owner');

Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');

Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');

Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index')->middleware('role:Administrator,Waiter,Owner');

Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');

Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');

Route::get('/order', [OrderController::class, 'index'])->name('order.index')->middleware('role:Waiter,Cashier,Owner');

Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::put('/order/{orderGroupId}', [OrderController::class, 'update'])->name('order.update');

Route::delete('/order/{orderGroupId}', [OrderController::class, 'destroy'])->name('order.destroy');

Route::post('/order/export-excel', [OrderController::class, 'exportExcel'])->name('order.export-excel');

Route::get('/table', [TableController::class, 'index'])->name('table.index')->middleware('role:Administrator,Owner');

Route::post('/table', [TableController::class, 'store'])->name('table.store');

Route::put('/table/{table}', [TableController::class, 'update'])->name('table.update');

Route::delete('/table/{table}', [TableController::class, 'destroy'])->name('table.destroy');

Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index')->middleware('role:Cashier,Owner');

Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

Route::put('/transaction/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');

Route::delete('/transaction/{transaction}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

Route::post('/transaction/export-excel', [TransactionController::class, 'exportExcel'])->name('transaction.export-excel');

Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('role:Administrator,Owner');

Route::post('/user', [UserController::class, 'store'])->name('user.store');

Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');

Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');