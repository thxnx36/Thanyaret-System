<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

// เปลี่ยนหน้าแรกให้เป็นหน้ารายการหัวข้อ
Route::get('/', [TopicController::class, 'index'])->name('home');

// เส้นทางสำหรับ Topic
Route::resource('topics', TopicController::class);

// เส้นทางสำหรับ Comment ภายใต้ Topic
Route::post('topics/{topic}/comments', [CommentController::class, 'store'])->name('comments.store');
