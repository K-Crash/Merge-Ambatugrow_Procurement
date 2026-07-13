<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequisitionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes - every approver / manager must log in.
| Each approval action is additionally checked in ApprovalController
| against the specific approval step assigned to that user, so a
| Finance Manager can never approve a Manager or Department Head step
| (and vice versa).
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'approver'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Create PO / Purchase Requisition
    Route::get('/requisitions/create', [RequisitionController::class, 'create'])->name('requisitions.create');
    Route::post('/requisitions', [RequisitionController::class, 'store'])->name('requisitions.store');
    Route::get('/requisitions/{requisition}/route', [RequisitionController::class, 'showRoute'])->name('requisitions.route');
    Route::post('/requisitions/{requisition}/route', [RequisitionController::class, 'storeRoute'])->name('requisitions.route.store');

    // Tracking / Order Management
    Route::get('/requisitions', [RequisitionController::class, 'tracking'])->name('requisitions.tracking');
    Route::get('/services/search', [RequisitionController::class, 'searchServices'])->name('services.search');

    // Approvals queue - role-restricted per approval step, not per page
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::get('/approvals/{requisition}', [ApprovalController::class, 'show'])->name('approvals.show');
    Route::post('/approvals/{requisition}/act', [ApprovalController::class, 'act'])->name('approvals.act');
});
