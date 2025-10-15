<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');