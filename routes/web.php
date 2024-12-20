<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;


// Public Routes
Route::get('/', [HomeController::class, 'homepages'])->name('home');
Route::get('/index', [ItemController::class, 'mainIndexs'])->name('index');
Route::get('/services', [HomeController::class, 'registers'])->name('services');
Route::get('/checkout', [HomeController::class, 'checkouts'])->name('checkout');
Route::get('/pay', [HomeController::class, 'pays'])->name('pay');
Route::get('/detail/{id}', [ItemController::class, 'details'])->name('detail'); // Correct route

// Search Items (Optional)
Route::get('/search-items', [ItemController::class, 'searchItems'])->name('search.items');

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process'); // Handle login

//register route
Route::get('/register', [HomeController::class, 'registers'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');


// Logout Route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/inventory', [AdminController::class, 'dashboard'])->name('inventory.index'); // View inventory
Route::get('/inventory/create', [AdminController::class, 'createInventoryItemForm'])->name('inventory.create'); // Create inventory form
Route::post('/inventory', [AdminController::class, 'storeInventoryItem'])->name('inventory.store'); // Store new item
Route::get('/inventory/{id}/edit', [AdminController::class, 'editInventoryItem'])->name('inventory.edit'); // Edit form
Route::put('/inventory/{id}', [AdminController::class, 'updateInventoryItem'])->name('admin.inventory.update'); // Update item
Route::delete('/inventory/{id}', [AdminController::class, 'deleteInventoryItem'])->name('inventory.delete'); // Delete item
