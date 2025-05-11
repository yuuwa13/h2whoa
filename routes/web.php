<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GcashController;

//For Customers
Route::get('/signup', [CustomerController::class, 'create'])->name('signup.form');
Route::post('/signup', [CustomerController::class, 'store'])->name('signup.store');
// show profile & edit form
Route::get('/profile', [CustomerController::class, 'show'])
     ->name('profile.show')
     ->middleware('auth:customer');
// handle update
Route::put('/profile', [CustomerController::class, 'update'])
     ->name('profile.update')
     ->middleware('auth:customer');
// Delete own account
Route::delete('/profile', [CustomerController::class, 'destroy'])
     ->name('profile.destroy')
     ->middleware('auth:customer');

//For Login
Route::get('/login', [LoginController::class, 'showLoginForm'])
     ->name('login.form');
// handle login
Route::post('/login', [LoginController::class, 'login'])
     ->name('login.submit');
// forgot-password part: TBA(?)
Route::get('/forgot-password', fn() => 'Forgot Password — Coming Soon')
     ->name('password.request');
// admin login part: TBA
Route::get('/admin-login', fn() => 'Admin Login — Coming Soon')
     ->name('admin.login');


Route::get('/', function () {
     return view('homepage');
});
Route::get('/invoice', function () {
     return view('invoice');
});
Route::get('/contact-us', function () {
     return view('online_contactUs');
})->name('contact.us');

Route::get('/order-history', [OrderController::class, 'historyOrders'])->name('orders.history');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::post('/orders/update-quantities', [OrderController::class, 'updateQuantities'])->name('orders.updateQuantities');
Route::post('/orders/save-changes', [OrderController::class, 'saveChanges'])->name('orders.saveChanges');
Route::post('/orders/save', [OrderController::class, 'save'])->name('orders.save');

Route::post('/orders/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
Route::post('/orders/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::post('/orders/save-address', [OrderController::class, 'saveAddress'])->name('orders.saveAddress');

Route::get('/track-orders', [OrderController::class, 'trackOrders'])->name('track.orders');


Route::get('/locate-address', function () {
     return view('locate_address');
})->name('locate.address');

Route::get('/mode-payment', [OrderController::class, 'modePayment'])->name('mode.payment');

Route::get('/delivery-details', function () {
    $customer = Auth::guard('customer')->user(); // Get the authenticated customer
    return view('delivery_details', compact('customer'));
})->name('delivery.details');

Route::get('/payment/gcash', function () {
     $subtotal = session('subtotal', 0);
     $deliveryFee = session('deliveryFee', 50);
     $total = session('total', $subtotal + $deliveryFee);

     return view('gcash', compact('subtotal', 'deliveryFee', 'total'));
})->name('gcash.payment');

Route::post('/gcash/store', [GcashController::class, 'store'])->name('gcash.store');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');

Route::get('/admin/history', function () {
     return view('admin_history');
})->name('admin.history');
Route::get('/admin/stocks', function () {
     return view('admin_stocks');
})->name('admin.stocks');

Route::get('/admin', function () {
     return view('admin_index');
})->name('admin.dashboard');

Route::get('/admin/orders', function () {
     return view('admin_orders');
})->name('admin.orders');


//Placeholder routes for some of those footer navigation stuff

Route::get('/company-information', fn() => 'Company Info — Coming Soon')
     ->name('company.info');

Route::get('/reviews', fn() => 'Reviews — Coming Soon')
     ->name('reviews');

Route::get('/terms-of-service', fn() => 'Terms of Service — Coming Soon')
     ->name('legal.tos');

Route::get('/terms-of-use', fn() => 'Terms of Use — Coming Soon')
     ->name('legal.tou');

Route::get('/privacy-policy', fn() => 'Privacy Policy — Coming Soon')
     ->name('legal.privacy');
