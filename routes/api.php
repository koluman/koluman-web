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

Route::post('/userlogin', [LoginController::class, 'userlogin'])->name('userlogin');
Route::post('/userlogout', [LoginController::class, 'userlogout'])->name('userlogout');

Route::middleware(['jwt.verify'])->group(function () {
    Route::post('/testdriveadd', [TestDriveController::class, 'testdriveadd'])->name('testdriveadd');
    Route::post('/testdriveget', [TestDriveController::class, 'testdriveget'])->name('testdriveget');
    Route::post('/deleteTestDrive', [TestDriveController::class, 'deleteTestDrive'])->name('deleteTestDrive');
});


