<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'procurement')->name('procurement.home');
Route::view('/purchase', 'purchase')->name('procurement.purchase');
Route::view('/createpo', 'createpo')->name('procurement.create');
Route::view('/sidenotif', 'sidenotif')->name('procurement.notifications');


