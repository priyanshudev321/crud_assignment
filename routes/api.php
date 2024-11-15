<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post( 'login', [ AuthController::class, 'login' ] );

Route::middleware('auth:api')->group(function () {

    Route::prefix('blogs')->group(function() {

        Route::post( 'create', [ PostController::class, 'createPosts' ] ); 
        Route::get( 'list', [ PostController::class, 'postsList' ] ); 
        Route::post( 'update', [ PostController::class, 'updatePost' ] ); 
        Route::get( 'details/{id?}', [ PostController::class, 'postDetails' ] ); 
        Route::get( 'delete/{id?}', [ PostController::class, 'deletePost' ] );

    });

});
