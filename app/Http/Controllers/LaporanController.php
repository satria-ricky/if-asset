<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function list_laporan() {
        $title = "Daftar Laporan";
        $dataRuangan = Ruangan::all();
        $dataLaporan = Laporan::all();
        return view("fitur.kaprodi.list_laporan", compact("loc","dataRuangan","title"));
    }

}
