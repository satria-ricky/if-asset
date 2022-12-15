<?php


use App\Models\Aset;
use App\Models\Histori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\JenisAsetController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RuanganController;
use App\Models\JenisAset;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use LaravelQRCode\Facades\QRCode as FacadesQRCode;

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

    Route::get('/qr_code/{id}', [AsetController::class, 'qr_code']);

    Route::get('/qr_codeRuangan/{id}', [RuanganController::class, 'qr_code']);

    
    Route::post('/asetById', [AsetController::class, 'asetById'])->name('asetById');


    //FILTER
    Route::post('/getRuanganByJurusan', [RuanganController::class, 'getRuanganByJurusan']);

    Route::post('/asetByRuangan', [AsetController::class, 'asetByRuangan'])->name('asetByRuangan');
    

    //HISTORI
    Route::get('/histori_aset',[HistoriController::class,'histori_aset']);
    Route::post('/filterHistori',[HistoriController::class,'filterHistori']);

    Route::get('/histori_ruangan',[HistoriController::class,'histori_ruangan']);



    //SELESAI DIPAKAI
    Route::post('/selesai_dipakai',[HistoriController::class,'selesai_dipakai']);
    Route::post('/selesai_dipakai_ruangan',[HistoriController::class,'selesai_dipakai_ruangan']);



    Route::post('/logout', [UserController::class, 'logout']);
});

Route::group(['middleware' => ['auth','ceklevel:1']], function () {

    //JURUSAN
    Route::get('/list_jurusan',[JurusanController::class,'list_jurusan']);
    Route::post('/tambah_jurusan', [JurusanController::class, 'tambah_jurusan']);
    Route::post('/edit_jurusan', [JurusanController::class, 'edit_jurusan']);
    Route::post('/hapus_jurusan', [JurusanController::class, 'hapus_jurusan']);

    //RUANGAN
    Route::get('/list_ruangan',[RuanganController::class,'list_ruangan']);
    Route::post('/tambah_ruangan', [RuanganController::class, 'tambah_ruangan']);
    Route::post('/edit_ruangan', [RuanganController::class, 'edit_ruangan']);
    Route::post('/hapus_ruangan', [RuanganController::class, 'hapus_ruangan']);


    //JENIS ASET
    Route::get('/list_jenis_aset',[JenisAsetController::class,'list_jenis_aset']);
    Route::post('/tambah_jenis_aset', [JenisAsetController::class, 'tambah_jenis_aset']);
    Route::post('/hapus_jenis_aset', [JenisAsetController::class, 'hapus_jenis_aset']);
    Route::post('/edit_jenis_aset', [JenisAsetController::class, 'edit_jenis_aset']);



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

// Route::group(['middleware' => ['auth','ceklevel:3']], function () {
//     Route::get('/list_histori',[HistoriController::class,'list_histori']);
    
// });

Route::group(['middleware' => ['auth','ceklevel:4']], function () {
    Route::get('/list_historiDsn',[HistoriController::class,'list_histori_ruangan']);
   
});

Route::get('/', [UserController::class, 'tampil_home']);
Route::get('/auth', [UserController::class, 'tampil_login'])->name("login");
Route::post('/login', [UserController::class, 'login']);
Route::get('/detail_aset/{id}', [AsetController::class, 'tampil_detail_aset']);

Route::get('/detail_ruangan/{id}', [RuanganController::class, 'tampil_detail_ruangan']);

//FROM QRCODE
Route::get('/authAset/{id_aset}', [UserController::class, 'tampil_loginAset']);
Route::post('/loginAset', [UserController::class, 'loginAset']);

Route::get('/authRuangan/{id_ruangan}', [UserController::class, 'tampil_loginRuangan']);
Route::post('/loginRuangan', [UserController::class, 'loginRuangan']);



