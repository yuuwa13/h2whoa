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