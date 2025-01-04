<?php

use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::prefix('v1')->middleware('auth:sanctum')->group(function(){
    route::get('/posts',[PostController::class,'index'])->name('posts.index');
    route::post('/posts',[PostController::class,'store'])->name('posts.store');
    route::get('/posts/{id}',[PostController::class,'show'])->name('posts.show');
    route::put('/posts/{id}',[PostController::class,'update'])->name('posts.update');
    route::delete('/posts/{id}',[PostController::class,'destroy'])->name('posts.destroy');
});








