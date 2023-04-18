<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RedirectController;

//halaman input email untuk reset password
Route::get('/reset_password', [ResetPasswordController::class, 'konfirmasi_email']);

//kirim permintaan reset ke email yang telah diinput
Route::post('/reset_password/kirim_email_reset', [ResetPasswordController::class, 'permintaan_reset_password']);

//mengirim email tautan (link token) untuk reset password ke email yang telah diinput
Route::get('/token_reset_password/{token}', [ResetPasswordController::class, 'halaman_reset_password'])->name('reset.password.get');

Route::post('/halaman_reset_password', [ResetPasswordController::class, 'submit_reset_password']);


Route::group(['middleware' => ['auth', 'checkrole:1,2,3,4']], function () {
    Route::get('/redirect', [RedirectController::class, 'cek']);
});

//  jika user belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'dologin']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Registrasi
Route::get('/registrasi', [RegisterController::class, 'index']);
Route::resource('/registrasi/registrasi_akun', RegisterController::class);



// Role
// 1 = superadmin
// 2 = admin
// 3 = manager
// 4 = pegawai

// untuk Superadmin
Route::group(['middleware' => ['auth', 'checkrole:1', 'checkstatus:aktif']], function () {
    Route::get('/superadmin', [SuperadminController::class, 'index']);
    Route::resource('/superadmin/crud', SuperadminController::class);
    Route::get('/superadmin/datauseraktif', [SuperadminController::class, 'halaman_datauser']);
    Route::get('/superadmin/datausernonaktif', [SuperadminController::class, 'halaman_datauser_nonaktif']);
    Route::get('/superadmin/datapegawai', [SuperadminController::class, 'halaman_datapegawai']);

    Route::get('/superadmin/lihatdatauser/{id}', [SuperadminController::class, 'show'])->name('lihat_data_pegawai');

    Route::post('/superadmin/aktivasi_semua_user', [SuperadminController::class, 'aktivasi_semua_user']);

});

Route::get('/getpegawaidata/{nip}', [SuperadminController::class, 'getPegawaiData'])->name('getpegawaidata');


// untuk Admin
Route::group(['middleware' => ['auth', 'checkrole:2', 'checkstatus:aktif']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// untuk Manager
Route::group(['middleware' => ['auth', 'checkrole:3', 'checkstatus:aktif']], function () {
    Route::get('/manager', [ManagerController::class, 'index']);
});


// untuk pegawai
Route::group(['middleware' => ['auth', 'checkrole:4']], function () {
    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::get('/pegawai/permintaan_software', [PegawaiController::class, 'permintaan_software']);
    Route::post('/pegawai/simpan_software', [PegawaiController::class, 'simpan_software']);
    Route::get('/form_instalasi_software/{id}', [PegawaiController::class, 'getDataRequest'])->name('lihat_form');
});
