<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\FaqController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/loans/my-loans', [LoanRequestController::class, 'index'])->name('loans.index'); // Halaman Status/Riwayat
    Route::get('/loans/create/{item}', [LoanRequestController::class, 'create'])->name('loans.create'); // Form Pinjam
    Route::post('/loans', [LoanRequestController::class, 'store'])->name('loans.store'); // Proses Simpan
    Route::resource('items', ItemController::class);
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
});

Route::prefix('admin')->group(function () {
    Route::get('/loans', [LoanRequestController::class, 'adminIndex'])->name('admin.loans.index');
    Route::post('/loans/{id}/approve', [LoanRequestController::class, 'approve'])->name('admin.loans.approve');
    Route::post('/loans/{id}/reject', [LoanRequestController::class, 'reject'])->name('admin.loans.reject');
    Route::post('/loans/{id}/pickup', [LoanRequestController::class, 'pickup'])->name('admin.loans.pickup');
    Route::post('/loans/{id}/return', [LoanRequestController::class, 'returnItem'])->name('admin.loans.return');
    Route::get('/faqs', [FaqController::class, 'adminIndex'])->name('admin.faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('admin.faqs.store');
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('admin.faqs.destroy');
});

require __DIR__ . '/auth.php';
