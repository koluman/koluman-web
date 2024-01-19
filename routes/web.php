<?php

use App\Http\Controllers\Admin\BackUsersController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Ajans\AjansHomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [AuthController::class, 'signin'])->name('signin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admindashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/adminusers', [HomeController::class, 'users'])->name('admin.users');
    Route::post('/getallusers', [BackUsersController::class, 'getallusers'])->name('getallusers');
    Route::post('/adduser', [BackUsersController::class, 'adduser'])->name('adduser');
    Route::post('/updateuser', [BackUsersController::class, 'updateuser'])->name('updateuser');
    Route::post('/deleteuser', [BackUsersController::class, 'deleteuser'])->name('deleteuser');
    Route::post('/deleteusers', [BackUsersController::class, 'deleteusers'])->name('deleteusers');

    
});

Route::middleware(['checkRole:ajans'])->group(function () {
    Route::get('/ajansdashboard', [AjansHomeController::class, 'dashboard'])->name('ajans.dashboard');
});


