<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/orders', function () {
    return view('online_orders');
});
Route::get('/sign-up', function () {
    return view('online_signUp');
});
Route::get('/cod-payment', function () {
    return view('payment1');
});
Route::get('/online-payment', function () {
    return view('payment2');
});

use App\Http\Controllers\UserController;
//This route is basically for a logged in user to view their "profile"
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('user.profile');
//Create User Controller route
Route::post('/users', [UserController::class, 'store'])->name('users.store');
//Change password Controller route
Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
//Basically a route for the user to edit their profile
Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/profile/update', [UserController::class, 'update'])->name('user.update');
//Route for the user to delete their account
Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('user.destroy');


