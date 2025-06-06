<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\BookController;
use App\Http\Controllers\Frontend\LoanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{buku}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/{buku}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::get('/my-loans', [LoanController::class, 'history'])->name('loans.history');
});

require __DIR__.'/auth.php';
