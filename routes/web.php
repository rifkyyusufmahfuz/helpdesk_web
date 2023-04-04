<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;


//  jika user belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'dologin']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Role
// 1 = superadmin
// 2 = admin
// 3 = manager
// 4 = pegawai
Route::group(['middleware' => ['auth', 'checkrole:1,2,3,4']], function () {
    Route::get('/redirect', [RedirectController::class, 'cek']);
});


// untuk Superadmin
Route::group(['middleware' => ['auth', 'checkrole:1']], function () {
    Route::get('/superadmin', [SuperadminController::class, 'index']);
    Route::resource('/superadmin/crud', SuperadminController::class);
    Route::get('/superadmin/datauser', [SuperadminController::class, 'halaman_datauser']);
    Route::get('/superadmin/datapegawai', [SuperadminController::class, 'halaman_datapegawai']);

    // Route::post('/get-pegawai-data', [SuperadminController::class, 'halaman_datauser']);

    Route::get('/getpegawaidata/{nip}', [SuperadminController::class, 'getPegawaiData'])->name('getpegawaidata');
});

// untuk Admin
Route::group(['middleware' => ['auth', 'checkrole:2']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// untuk Manager
Route::group(['middleware' => ['auth', 'checkrole:3']], function () {
    Route::get('/manager', [ManagerController::class, 'index']);
});

// untuk pegawai
Route::group(['middleware' => ['auth', 'checkrole:4']], function () {
    Route::get('/pegawai', [PegawaiController::class, 'index']);
});
