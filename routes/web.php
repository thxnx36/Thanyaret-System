<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Topics
Route::resource('topics', TopicController::class);

// Comments
Route::post('/topics/{topic}/comments', [CommentController::class, 'store'])->name('comments.store');

// Admin panel routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User management
    Route::get('users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    
    // Topic management
    Route::get('topics', [AdminController::class, 'topics'])->name('admin.topics');
    Route::get('topics/{topic}', [AdminController::class, 'showTopic'])->name('admin.topics.show');
    Route::delete('topics/{topic}', [AdminController::class, 'destroyTopic'])->name('admin.topics.destroy');
    
    // Comment management
    Route::get('comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::delete('comments/{comment}', [AdminController::class, 'destroyComment'])->name('admin.comments.destroy');
});
