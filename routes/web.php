<?php

use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('home');
});

// Static pages
Route::get('/home', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Change the undefined route to use borrows.index since it's the same thing
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Categories management
        Route::resource('categories', CategoryController::class);

        // Books management
        Route::resource('books', BookController::class);
        Route::get('books/print/list', [BookController::class, 'printList'])->name('books.print.list');
        Route::get('books/{book}/print', [BookController::class, 'printDetail'])->name('books.print.detail');

        // Borrows management
        Route::group(['prefix' => 'borrows', 'as' => 'borrows.'], function () {
            Route::get('/', [BorrowController::class, 'index'])->name('index');
            Route::get('/pending', [BorrowController::class, 'pending'])->name('pending');
            Route::get('/{borrow}', [BorrowController::class, 'show'])->name('show');
            Route::post('{borrow}/approve', [BorrowController::class, 'approve'])->name('approve');
            Route::post('{borrow}/return', [BorrowController::class, 'return'])->name('return');
            Route::get('/print/history', [BorrowController::class, 'printHistory'])->name('print.history');
        });

        // Reviews management
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            Route::patch('{review}/pin', [AdminReviewController::class, 'pin'])->name('pin');
            Route::patch('{review}/unpin', [AdminReviewController::class, 'unpin'])->name('unpin');
            Route::delete('{review}', [AdminReviewController::class, 'destroy'])->name('destroy');
        });
    });

    // User routes
    Route::middleware(['role:user'])->name('user.')->prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        // User book routes
        Route::get('/books', [BookController::class, 'userIndex'])->name('books.index');
        Route::get('/books/{book}', [BookController::class, 'userShow'])->name('books.show');

        // User review routes
        Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // User borrow routes
        Route::post('/borrows', [BorrowController::class, 'store'])->name('borrows.store');
        Route::get('/borrows', [BorrowController::class, 'userBorrows'])->name('borrows');
        Route::get('/borrows/{borrow}', [BorrowController::class, 'userShow'])->name('borrows.show');
        Route::post('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    });

    // Common authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

