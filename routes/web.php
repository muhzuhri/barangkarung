<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('manual-auth.login');
})->name('login');

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');

Route::get('/pesanan', function () {
    return view('pesanan');
})->name('pesanan');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');