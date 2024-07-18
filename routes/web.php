<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthTwoController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTwoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [UserTwoController::class, 'home']);
Route::get('/contact', [UserTwoController::class, 'contactPage']);
Route::get('/register/form', [AuthTwoController::class, 'loadRegisterForm']);
Route::post('/register/user', [AuthTwoController::class, 'registerUser'])->name('registerUser');
Route::get('/login/form', [AuthTwoController::class, 'loadLoginPage']);
Route::post('/login/user', [AuthTwoController::class, 'loginUser'])->name('loginUser');
Route::get('/home', [AuthTwoController::class, 'loadHomePage']);
Route::get('/logout', [AuthTwoController::class, 'logoutUser']);
Route::get('/forgot/form', [AuthTwoController::class, 'loadForgotPage']);
Route::post('/forgot', [AuthTwoController::class, 'forgot'])->name('forgot');
Route::get('/404', [AuthTwoController::class, 'fourOfour']);
Route::get('/faq', [UserTwoController::class, 'faq']);
Route::get('/user/home', [UserController::class, 'loadHomePage'])->middleware('user');
Route::get('/admin/home', [AdminController::class, 'loadHomePage'])->middleware('admin');
Route::get('/myposts', [UserController::class, 'loadMyPosts'])->middleware('user');
Route::get('/create/post', [UserController::class, 'loadCreatePost'])->middleware('user');
Route::get('/edit/post/{post_id}', [UserController::class,'loadEditPost'])->middleware('user');
Route::get('/view/posts', [UserController::class, 'loadViewPost'])->middleware('user');
Route::get('/view/post/{post_id}', [UserController::class, 'ViewPost'])->middleware('user');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirectToGoogle');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('handleGoogleCallback');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
