<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get( '/dashboard', [ DashboardController::class, 'viewDashboard' ] )->middleware('verified')->name('dashboard');

    // Add Posts
    Route::get( 'posts/add',  [ BlogPostController::class, 'viewAddPost' ] )->name('view.add-post');
    Route::post( 'posts/create', [ BlogPostController::class, 'createPost' ] )->name('create.post');
    Route::get( 'posts/update/{id?}', [ BlogPostController::class, 'viewEditPost' ] )->name('view.edit-post');
    Route::post( 'posts/update', [ BlogPostController::class, 'updatePost' ] )->name('update.post');
    Route::get( 'posts/delete/{id?}', [ BlogPostController::class, 'deletePost' ] )->name('delete.post');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
