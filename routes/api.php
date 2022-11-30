<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('karyawan','KaryawanController@index')->name('karyawan.index');
    Route::get('karyawan/{id}','KaryawanController@get')->name('karyawan.get');
    Route::post('karyawan','KaryawanController@store')->name('karyawan.store');
    Route::put('karyawan/{id}','KaryawanController@update')->name('karyawan.update');
    Route::delete('karyawan/{id}','KaryawanController@destroy')->name('karyawan.destroy');

    Route::get('jadwal','JadwalController@index')->name('jadwal.index');
    Route::get('jadwal/{id}','JadwalController@get')->name('jadwal.get');
    Route::post('jadwal','JadwalController@store')->name('jadwal.store');
    Route::put('jadwal/{id}','JadwalController@update')->name('jadwal.update');
    Route::delete('jadwal/{id}','JadwalController@destroy')->name('jadwal.destroy');

    Route::get('jadwalKaryawan','JadwalKaryawanController@index')->name('jadwalKaryawan.index');
    Route::get('jadwalKaryawan/{id}','JadwalKaryawanController@get')->name('jadwalKaryawan.get');
    Route::post('jadwalKaryawan','JadwalKaryawanController@store')->name('jadwalKaryawan.store');
    Route::put('jadwalKaryawan/{id}','JadwalKaryawanController@update')->name('jadwalKaryawan.update');
    Route::delete('jadwalKaryawan/{id}','JadwalKaryawanController@destroy')->name('jadwalKaryawan.destroy');

    Route::get('absenType','AbsenTypeController@index')->name('absenType.index');
    Route::get('absenType/{id}','AbsenTypeController@get')->name('absenType.get');
    Route::post('absenType','AbsenTypeController@store')->name('absenType.store');
    Route::put('absenType/{id}','AbsenTypeController@update')->name('absenType.update');
    Route::delete('absenType/{id}','AbsenTypeController@destroy')->name('absenType.destroy');

    Route::get('absenLog','AbsenLogController@index')->name('absenLog.index');
    Route::get('absenLog/{id}','AbsenLogController@get')->name('absenLog.get');
    Route::post('absenLog','AbsenLogController@store')->name('absenLog.store');
    Route::put('absenLog/{id}','AbsenLogController@update')->name('absenLog.update');
    Route::delete('absenLog/{id}','AbsenLogController@destroy')->name('absenLog.destroy');

    Route::get('dept','DeptController@index')->name('dept.index');
    Route::get('dept/{id}','DeptController@get')->name('dept.get');
    Route::post('dept','DeptController@store')->name('dept.store');
    Route::put('dept/{id}','DeptController@update')->name('dept.update');
    Route::delete('dept/{id}','DeptController@destroy')->name('dept.destroy');
});
