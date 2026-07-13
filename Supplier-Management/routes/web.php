<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Supplier Management Routes
|--------------------------------------------------------------------------
| All 9 screens are wired together here. Supplier-specific pages take a
| {supplier} slug (e.g. "abc-farms") so the sidebar tabs (Overview,
| Products, Purchase History, Contract, Performance) stay on the same
| supplier as you click between them.
*/

Route::get('/', function () {
    return redirect()->route('suppliers.dashboard');
});

// Image 1 - Supplier Management dashboard (KPI cards, top suppliers, etc.)
Route::get('/suppliers/dashboard', [SupplierController::class, 'dashboard'])
    ->name('suppliers.dashboard');

// Image 9 - Blacklisted suppliers
Route::get('/suppliers/blacklisted', [SupplierController::class, 'blacklistedIndex'])
    ->name('suppliers.blacklisted');

// Image 2 - Add new supplier
Route::get('/suppliers/create', [SupplierController::class, 'create'])
    ->name('suppliers.create');
Route::post('/suppliers', [SupplierController::class, 'store'])
    ->name('suppliers.store');

// Image 3 - Suppliers list ("View all suppliers")
Route::get('/suppliers', [SupplierController::class, 'index'])
    ->name('suppliers.index');

Route::get('/suppliers/active', [SupplierController::class, 'activeIndex'])
    ->name('suppliers.active');

Route::get('/suppliers/pending', [SupplierController::class, 'pendingIndex'])
    ->name('suppliers.pending');

// Images 4-8 - Supplier detail tabs, all scoped to one supplier slug
Route::prefix('/suppliers/{supplier}')->name('suppliers.')->group(function () {
    Route::get('/', [SupplierController::class, 'show'])->name('show');
    Route::get('/products', [SupplierController::class, 'products'])->name('products');
    Route::get('/purchase-history', [SupplierController::class, 'purchaseHistory'])->name('purchase-history');
    Route::get('/contract', [SupplierController::class, 'contract'])->name('contract');
    Route::get('/performance', [SupplierController::class, 'performance'])->name('performance');
});
