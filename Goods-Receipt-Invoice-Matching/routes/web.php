<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchingController;

Route::get('/', [MatchingController::class, 'index'])->name('matching.index');
