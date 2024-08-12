<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

// NOTE: le indicamos que el login sea la pagina principal
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

// NOTE: Rutas para las publicaciones de las imagenes
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// NOTE: Rutas para las imagenes
Route::get('/image', [ImageController::class, 'create'])->name('image.create');
Route::get('/image/details/{id}', [ImageController::class, 'details'])->name('image.details');
Route::post('/image/save', [ImageController::class, 'save'])->name('image.save');
Route::get('/image/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/edit/{id}', [ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update',[ImageController::class, 'update'])->name('image.update');

// NOTE: Rutas para los comentarios
Route::post('/comment/save', [CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

// NOTE: Rutas para los likes
Route::get('/like/list', [LikeController::class, 'myLikes'])->name('like.list');
Route::get('/like/save/{id}', [LikeController::class, 'like'])->name('like.save');
Route::get('/like/delete/{id}', [LikeController::class, 'dislike'])->name('like.delete');

// NOTE: Rutas para los usuarios
Route::get('/profile/list/{search?}', [ProfileController::class, 'index'])->name('profile.list');
Route::get('/profile/myProfile', [ProfileController::class, 'myProfile'])->name('profile.myProfile');
Route::get('/profile/viewProfile/{id}', [ProfileController::class, 'viewProfile'])->name('profile.viewProfile');

require __DIR__.'/auth.php';
