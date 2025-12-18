<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ItemController; // <--- INI WAJIB ADA AGAR TIDAK ERROR

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP UTAMA (MEMBUTUHKAN LOGIN)
Route::middleware('auth')->group(function () {
    // 1. Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Item Routes (Daftar Barang)
    // Pastikan ItemController ada di App/Http/Controllers/ItemController.php
    Route::resource('items', ItemController::class);

    // 3. Loan/Peminjaman Routes
    Route::get('/loans/my-loans', [LoanRequestController::class, 'index'])->name('loans.index'); 
    Route::get('/loans/create/{item}', [LoanRequestController::class, 'create'])->name('loans.create'); 
    Route::post('/loans', [LoanRequestController::class, 'store'])->name('loans.store'); 

    // 4. FAQ Routes (User)
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
});

// GRUP ADMIN
// Sebaiknya pakai middleware auth agar aman
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Loan Approval
    Route::get('/loans', [LoanRequestController::class, 'adminIndex'])->name('admin.loans.index');
    Route::post('/loans/{id}/approve', [LoanRequestController::class, 'approve'])->name('admin.loans.approve');
    Route::post('/loans/{id}/reject', [LoanRequestController::class, 'reject'])->name('admin.loans.reject');
    Route::post('/loans/{id}/pickup', [LoanRequestController::class, 'pickup'])->name('admin.loans.pickup');
    Route::post('/loans/{id}/return', [LoanRequestController::class, 'returnItem'])->name('admin.loans.return');
    
    // FAQ Management
    Route::get('/faqs', [FaqController::class, 'adminIndex'])->name('admin.faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('admin.faqs.store');
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('admin.faqs.destroy');
});

require __DIR__ . '/auth.php';