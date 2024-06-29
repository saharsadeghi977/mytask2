<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController AS PC;
use App\Http\Controllers\UserController AS UC;
 use App\Http\Controllers\Auth\LoginController;
 use App\Http\Controllers\Auth\RegisterController;


Route::get('/register',[RegisterController::class,'showRegisterForm'])->name('register');
Route::post('/register',[RegisterController::class,'register']);
Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class,'login']);
Route::get('/logout',[LoginController::class,'logoute'])->name('logout');
Route::middleware(['auth'])->group(function(){
Route::get('/create',[PC::class,'create'])->name('posts.create');
Route::post('/store',[PC::class,'store'])->name('post.store');
});
Route::middleware(['auth'])->group(function(){
 Route::get('/users',[UC::class,'index'])->name('index');
 Route::get('/users/{user}',[UC::class,'show'])->name('posts.index');
});
// Route::get('/index',[UC::class,'index'])->name('index')

