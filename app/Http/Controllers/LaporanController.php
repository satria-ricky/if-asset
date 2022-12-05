<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kondisi;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    //PRODI
    public function list_laporan() {
        $title = "Daftar Laporan";
        $dataRuangan = Ruangan::all();
        $dataLaporan = Laporan::all();
        $dataAset = Aset::all();
        return view("fitur.kaprodi.list_laporan", compact("dataAset","dataRuangan","title"));
    }


    //ADMIN
    public function adm_laporan() {
        $title = "Daftar Laporan";
        $dataKondisi = Kondisi::all();
        $dataLaporan = DB::table('laporans')
            ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.kondisi')->get();
        // dd($dataLaporan);
        $dataAset = Aset::all();
        return view("fitur.adm_laporan", compact("dataLaporan","dataAset","dataKondisi","title"));
    }


    public function tambah_laporan(Request $req)
    {
        // dd($req);

        $hasil = [
            'id_aset' => $req['id_aset'],
            'checked_at' => $req['checked_at']
        ];

        Laporan::create($hasil);
        Aset::all()->where('id_aset', $req['id_aset'])->first()->update([
            'kondisi' => $req['kondisi']
        ]);

        return redirect('/adm_laporan')->with('success', 'Data Berhasil Ditambah');
    }

    public function hapus_laporan(Request $req)
    {
        $data = Laporan::findOrFail($req['id']);
        $data->delete();

        return redirect('/adm_laporan')->with('success', 'Data Berhasil Dihapus');
    }

}