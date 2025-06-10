<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CometChatController;

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
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
});

// User routes
Route::middleware(['auth', 'role:user'])->name('user.')->prefix('user')->group(function () {
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
    Route::get('/cometchat/token', [CometChatController::class, 'getAuthToken'])->name('cometchat.token');
});

// Public routes
Route::get('/', function () {
    return view('welcome');
});
