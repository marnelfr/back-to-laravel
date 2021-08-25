<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterContoller;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comment', [PostCommentsController::class, 'store'])->middleware('auth');

Route::get('user', function (){ddd('ok');})->name('user');

Route::middleware('guest')->group(function() {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [SessionController::class, 'create']);
    Route::post('login', [SessionController::class, 'store']);
});

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');



Route::middleware('admin')->group(function () {
    Route::get('admin', [AdminPostController::class, 'index'])->name('dashboard');
    Route::get('admin/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('admin/posts', [AdminPostController::class, 'store']);
    Route::get('admin/posts/{post:slug}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::patch('admin/posts/{post:slug}', [AdminPostController::class, 'update'])->name('posts.update');
//    Route::resource('admin/posts', AdminPostController::class);
});




Route::post('newsletter', NewsletterContoller::class);

Route::get('welcome', function () {
    if (auth()->check()) {
        ddd('ok');
    }
})->name('settings');
