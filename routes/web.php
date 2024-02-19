<?php

use App\Http\Controllers\Admin\BackUsersController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Ajans\AjansHomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoowroomController;
use App\Http\Controllers\Sigorta\SigortaHomeController;
use App\Http\Controllers\TestDriveController;
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
Route::get('/getApiToken', [HomeController::class, 'getApiToken'])->name('getApiToken');
Route::get('/getBasicToken', [HomeController::class, 'getBasicToken'])->name('getBasicToken');
Route::middleware(['prevent-back-history', 'checkRole:admin'])->group(function () {
    Route::get('/admindashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/adminusers', [HomeController::class, 'users'])->name('admin.users');
    Route::get('/admintestdrive', [HomeController::class, 'testdrive'])->name('admin.testdrive');
    Route::post('/getallusers', [BackUsersController::class, 'getallusers'])->name('getallusers');
    Route::post('/adduser', [BackUsersController::class, 'adduser'])->name('adduser');
    Route::post('/updateuser', [BackUsersController::class, 'updateuser'])->name('updateuser');
    Route::post('/deleteuser', [BackUsersController::class, 'deleteuser'])->name('deleteuser');
    Route::post('/deleteusers', [BackUsersController::class, 'deleteusers'])->name('deleteusers');
    Route::get('/testdrivegetall', [TestDriveController::class, 'testdrivegetall'])->name('testdrivegetall');
    Route::post('/getapiusers', [UserController::class, 'getapiusers'])->name('getapiusers');
    Route::post('/deletetestdriveappointment', [TestDriveController::class, 'deletetestdriveappointment'])->name('deletetestdriveappointment');
    Route::post('/addtestdriveappointment', [TestDriveController::class, 'addtestdriveappointment'])->name('addtestdriveappointment');
    Route::post('/updatetestdriveappointment', [TestDriveController::class, 'updatetestdriveappointment'])->name('updatetestdriveappointment');
    Route::post('/testdriveschedules', [TestDriveController::class, 'testdriveschedules'])->name('testdriveschedules');
    Route::post('/getsteps', [TestDriveController::class, 'getsteps'])->name('getsteps');
    Route::post('/getstepsall', [TestDriveController::class, 'getstepsall'])->name('getstepsall');

    
});
Route::middleware(['prevent-back-history', 'checkRole:ajans'])->group(function () {
    Route::get('/ajansdashboard', [AjansHomeController::class, 'dashboard'])->name('ajans.dashboard');
    Route::get('/gallery/{id?}', [AjansHomeController::class, 'gallery'])->name('ajans.gallery');
    Route::get('/shoowroomlist', [ShoowroomController::class, 'shoowroom'])->name('ajans.list');
    Route::get('/showroomdetail/{id?}', [ShoowroomController::class, 'shoowroomdetail'])->name('shoowroomdetail');
    Route::get('/getshowroomcars', [ShoowroomController::class, 'getshowroomcars'])->name('getshowroomcars');
    Route::get('/getshowroomcarcompany', [ShoowroomController::class, 'getshowroomcarcompany'])->name('getshowroomcarcompany');

    Route::post('addshowroom', [ShoowroomController::class, 'addshowroom'])->name('addshowroom');
    Route::post('updateshowroom', [ShoowroomController::class, 'updateshowroom'])->name('updateshowroom');
    Route::post('/getshowroomcarid', [ShoowroomController::class, 'getshowroomcarid'])->name('getshowroomcarid');
    Route::post('deleteshowroomimage', [ShoowroomController::class, 'deleteshowroomimage'])->name('deleteshowroomimage');
    Route::post('deleteshowroom', [ShoowroomController::class, 'deleteshowroom'])->name('deleteshowroom');
    Route::post('deletegallery', [ShoowroomController::class, 'deletegallery'])->name('deletegallery');

    
    
    
});
Route::middleware(['prevent-back-history', 'checkRole:sigorta'])->group(function () {
    Route::get('/sigortadashboard', [SigortaHomeController::class, 'dashboard'])->name('sigorta.dashboard');
    Route::get('/sigortalist', [SigortaHomeController::class, 'sigorta'])->name('sigorta.list');
    Route::post('/getallsigorta', [SigortaHomeController::class, 'getallsigorta'])->name('getallsigorta');
    Route::get('sigortadetail/{id?}', [SigortaHomeController::class, 'sigortadetail'])->name('sigortadetail');
    Route::post('getbyIdSigorta', [SigortaHomeController::class, 'getbyIdSigorta'])->name('getbyIdSigorta');
    Route::post('deletesigorta', [SigortaHomeController::class, 'deletesigorta'])->name('deletesigorta');
    Route::post('updatesigortareview', [SigortaHomeController::class, 'updatesigortareview'])->name('updatesigortareview');
    Route::post('updatesigortaresult', [SigortaHomeController::class, 'updatesigortaresult'])->name('updatesigortaresult');
    Route::post('addsigorta', [SigortaHomeController::class, 'addsigorta'])->name('addsigorta');
    Route::post('deletesigortapoliçe', [SigortaHomeController::class, 'deletesigortapoliçe'])->name('deletesigortapoliçe');
    Route::post('updatesigorta', [SigortaHomeController::class, 'updatesigorta'])->name('updatesigorta');

});
