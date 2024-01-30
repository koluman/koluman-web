<?php
use App\Http\Controllers\Mobil\AnnouncementController;
use App\Http\Controllers\Mobil\DealerShipsController;
use App\Http\Controllers\Mobil\InsuranceController;
use App\Http\Controllers\Mobil\LoginController;
use App\Http\Controllers\Mobil\ShoowroomController;
use App\Http\Controllers\Mobil\TestDriveController;
use App\Http\Controllers\Mobil\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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
Route::middleware(['jwt.verify'])->group(function () {
    Route::post('/addtestdriveappointment', [TestDriveController::class, 'addtestdriveappointment'])->name('addtestdriveappointment');
    Route::get('/getusertestdriveappointment', [TestDriveController::class, 'getusertestdriveappointment'])->name('getusertestdriveappointment');
    Route::post('/deletetestdriveappointment', [TestDriveController::class, 'deletetestdriveappointment'])->name('deletetestdriveappointment');
    Route::get('/testdriveschedules', [TestDriveController::class, 'testdriveschedules'])->name('testdriveschedules');
    Route::post('/userlogin', [LoginController::class, 'userlogin'])->name('userlogin');
    Route::post('/userlogout', [LoginController::class, 'userlogout'])->name('userlogout');
    Route::post('/userregister', [LoginController::class, 'userregister'])->name('userregister');
    Route::get('/getshowroomcars', [ShoowroomController::class, 'getshowroomcars'])->name('getshowroomcars');
    Route::get('/getannouncement', [AnnouncementController::class, 'getannouncement'])->name('getannouncement');
    Route::get('/getdealerships', [DealerShipsController::class, 'getdealerships'])->name('getdealerships');
    Route::get('/getuserinsurancelist', [InsuranceController::class, 'getuserinsurancelist'])->name('getuserinsurancelist');
    Route::post('/adduserinsurancelist', [InsuranceController::class, 'adduserinsurancelist'])->name('adduserinsurancelist');
    Route::post('/deleteuserinsurancelist', [InsuranceController::class, 'deleteuserinsurancelist'])->name('deleteuserinsurancelist');
    Route::post('/updateuserinsurancelist', [InsuranceController::class, 'updateuserinsurancelist'])->name('updateuserinsurancelist');


});
Route::post('/refresh', [TokenController::class, 'refresh'])->name('refresh');

