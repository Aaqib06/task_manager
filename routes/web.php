<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route (can be task list)
// Route::get('/dashboard', fn () => redirect()->route('tasks.index'))->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/dashboard', fn() => redirect()->route('tasks.index'))->name('dashboard');
});




Route::get('categories/{category}/subcategories', function(Category $category) {
    return response()->json($category->subCategories);
})->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::resource('tasks', TaskController::class)->except(['index']);
});


