<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function list_laporan() {
        $title = "Daftar Laporan";
        $dataRuangan = Ruangan::all();
        $dataLaporan = Laporan::all();
        $dataAset = Aset::all();
        return view("fitur.kaprodi.list_laporan", compact("dataAset","dataRuangan","title"));
    }

}
