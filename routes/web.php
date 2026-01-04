<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController; // Добавлена эта строка
// use App\Http\Middleware\LocaleMiddleware;

// Смена языка
Route::get('/lang/{lang}', [MainController::class, 'changeLocale'])->name('locale');

Route::get('/', [MainController::class, 'home'])->name('home');

// Гости
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Авторизованные
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Рецепты
    Route::resource('recipes', RecipeController::class)->except(['index']);
    
    // Отзывы к рецептам (внутри auth, так как оставлять отзывы могут только залогиненные)
    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Профиль (свой)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Просмотр профиля (публичный) - ставим в конце, чтобы не перекрыл edit
Route::get('/user/{username}', [ProfileController::class, 'show'])->name('profile.show');