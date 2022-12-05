<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function list_histori() {
        $title = "Daftar Histori";
        $dataRuangan = Ruangan::all();
        $dataLaporan = Laporan::all();
        $dataAset = Aset::all();
        return view("fitur.mhs.list_histori", compact("dataAset","dataRuangan","title"));
    }
}
