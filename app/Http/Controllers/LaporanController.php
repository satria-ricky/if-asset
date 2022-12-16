<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Jurusan;
use App\Models\Kondisi;
use App\Models\Laporan;
use App\Models\Ruangan;
use App\Models\JenisAset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class LaporanController extends Controller
{

    public function list_laporan()
    {
        $title = "Daftar Laporan";
        $dataRuangan = Ruangan::all();
        $dataJenis = JenisAset::all();
        $dataJurusan = Jurusan::all();
        $dataKondisi = Kondisi::all();
        $dataAset = Aset::all();
        
        $dataLaporan = DB::table('laporans')
            ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.id_kondisi')
            ->get();
        // dd($dataLaporan);
        return view("fitur.list_laporan", compact("dataLaporan", "dataRuangan", "dataJenis","dataJurusan","dataKondisi","dataAset", "title"));
    }


    
    public function filterLaporan(Request $req)
    {

        $data = DB::table('laporans')
            ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.id_kondisi')
            ->whereBetween('checked_at', [$req->awal, $req->akhir])
            ->where('asets.kode_jurusan', [$req->id_jurusan])
            ->where('asets.id_ruangan', [$req->id_ruangan])
            ->where('asets.id_jenis', [$req->id_jenis])
            ->where('asets.id_jenis', [$req->id_jenis])
            ->get();


        return Datatables::of($data)
            ->addColumn('id_kondisi', function ($data) {
                if ($data->id_kondisi == 1) {
                    $kondisi = '<p class="btn btn-danger btn-sm"> '.$data->nama_kondisi.' </p>';
                } else {
                    $kondisi = '<p class="btn btn-success btn-sm">  '.$data->nama_kondisi.' </p>';
                }
                return $kondisi;
            })
            ->rawColumns(['id_kondisi'])->make(true);
    }


    //ADMIN
   

    

    
    public function tambah_laporan(Request $req)
    {
        // dd($req);

        $hasil = [
            'id_aset' => $req['id_aset'],
            'checked_at' => $req['checked_at'],
            'id_kondisi' => $req['id_kondisi']
        ];

        Laporan::create($hasil);

        Aset::all()->where('id_aset', $req['id_aset'])->first()->update([
            'id_kondisi' => $req['id_kondisi']
        ]);

        return redirect('/list_laporan')->with('success', 'Data Berhasil Ditambah');
    }

    public function hapus_laporan(Request $req)
    {
        // dd($req);
        $data = Laporan::findOrFail($req['id']);
        $data->delete();

        return redirect('/list_laporan')->with('success', 'Data Berhasil Dihapus');
    }
}
