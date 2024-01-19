<?php

use App\Http\Controllers\Mobil\LoginController;
use App\Http\Controllers\Mobil\TestDriveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Diğer rotalarınız...
//Route::middleware(['auth:api'])->group(function () {
    Route::post('/test', [LoginController::class, 'test'])->name('test');
    Route::post('/getUserIDFromToken', [LoginController::class, 'getUserIDFromToken'])->name('getUserIDFromToken');
//});


