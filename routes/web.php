<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Models\Histori;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profil',  [UserController::class, 'tampil_profil']);


    Route::get('/qr_code/{id}', function($id){
        return view('fitur.qr_code',[
            'data' => url('detail_aset/'.$id)
        ]);

    });
    Route::post('/asetByRuangan', [AsetController::class, 'asetByRuangan'])->name('asetByRuangan');
    Route::post('/asetById', [AsetController::class, 'asetById'])->name('asetById');
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::group(['middleware' => ['auth','ceklevel:1']], function () {

    Route::get('/list_ruangan',[RuanganController::class,'list_ruangan']);
    Route::post('/tambah_ruangan', [RuanganController::class, 'tambah_ruangan']);
    Route::post('/edit_ruangan', [RuanganController::class, 'edit_ruangan']);
    Route::post('/hapus_ruangan', [RuanganController::class, 'hapus_ruangan']);
    Route::get('/list_aset',[AsetController::class,'list_aset']);

    Route::post('/tambah_aset', [AsetController::class, 'tambah_aset']);
    Route::post('/hapus_aset', [AsetController::class, 'hapus_aset']);
    Route::get('/edit_aset/{id}', [AsetController::class, 'tampil_edit_aset']);
    Route::post('/edit_aset', [AsetController::class, 'edit_aset']);

    Route::get('/adm_laporan',[LaporanController::class,'adm_laporan']);
    Route::post('/tambah_laporan',[LaporanController::class,'tambah_laporan']);
    Route::post('/hapus_laporan', [LaporanController::class, 'hapus_laporan']);
});


Route::group(['middleware' => ['auth','ceklevel:2']], function () {
    Route::get('/list_laporan',[LaporanController::class,'list_laporan']);
    Route::post('/filterLaporan',[LaporanController::class,'filterLaporan']);
});

Route::group(['middleware' => ['auth','ceklevel:3']], function () {
    Route::get('/list_histori',[HistoriController::class,'list_histori']);
});

Route::get('/', [UserController::class, 'tampil_home']);
Route::get('/auth', [UserController::class, 'tampil_login'])->name("login");
Route::post('/login', [UserController::class, 'login']);
Route::get('/detail_aset/{id}', [AsetController::class, 'tampil_detail_aset']);

