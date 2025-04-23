<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('homepage');
});
Route::get('/invoice', function () {
    return view('invoice');
});
Route::get('/contact-us', function () {
    return view('online_contactUs');
});
Route::get('/history', function () {
    return view('online_history');
});
Route::get('/login', function () {
    return view('online_logIn');
});


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');


Route::get('/sign-up', function () {
    return view('online_signUp');
});
Route::get('/cod-payment', function () {
    return view('payment1');
});
Route::get('/online-payment', function () {
    return view('payment2');
});
Route::get('/admin-history', function () {
    return view('admin_history');
});
Route::get('/admin-inventory', function () {
    return view('admin_inventory');
});