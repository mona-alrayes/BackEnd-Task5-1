<?php

use App\Http\Controllers\AdminCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'Dashboard'])->name('admin.Dashboard');
    Route::post('admin/dashboard/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::resource('admin/users', AdminUserController::class);
    Route::resource('admin/books', BookController::class);
    Route::resource('admin/Category', AdminCategoryController::class);
});


