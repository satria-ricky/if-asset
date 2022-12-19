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
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.kondisi_laporan')
            ->get();
        // dd($dataLaporan);
        return view("fitur.list_laporan", compact("dataLaporan", "dataRuangan", "dataJenis","dataJurusan","dataKondisi","dataAset", "title"));
    }


    
    public function filterLaporan(Request $req)
    {

        
        if ($req->refresh == 1) {
            $data = DB::table('laporans')
            ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.kondisi_laporan')
            ->get();
        } else {
            $data = DB::table('laporans')
            ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.kondisi_laporan')
            ->whereBetween('checked_at', [$req->tanggal_awal, $req->tanggal_akhir])
            ->where('asets.kode_jurusan', [$req->id_jurusan])
            ->where('asets.id_ruangan', [$req->id_ruangan])
            ->where('asets.id_jenis', [$req->id_jenis])
            ->get();
        }
        
        // return response()->json($data);


        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            $btn = '<div class="btn-group">
                <button data-toggle="dropdown"
                    class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item"
                            href="/detail_aset/' . Crypt::encrypt($data->id_aset) . '" target="_blank"> Detail</a>
                    </li>
                    <li>
                        <form action="/hapus_laporan" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '" />
                            <input type="hidden" name="id"
                                value="' . $data->id_laporan . '">
                            <button
                                style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
                                class="dropdown-item pb-2" type="submit"
                                onclick="return confirm(`Are you Sure`)">
                                Hapus</button>
                        </form>
                    </li>
                </ul>
            </div>';
            return $btn;
        })
        ->editColumn('id_kondisi',function ($data){
            return '<p class="btn btn-' . $data->icon_kondisi . ' btn-sm"> ' . $data->nama_kondisi . ' </p>'; 
        })
        ->rawColumns(['id_kondisi','action'])->make(true);
    }

    public function filterHistoriRuangan(Request $req)
    {

        
        // if ($req->refresh == 1) {
        //     $data = DB::table('laporans')
        //     ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
        //     ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
        //     ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
        //     ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
        //     ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.kondisi_laporan')
        //     ->get();
        // } else {
        //     $data = DB::table('laporans')
        //     ->leftJoin('asets', 'asets.id_aset', '=', 'laporans.id_aset')
        //     ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
        //     ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
        //     ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
        //     ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'laporans.kondisi_laporan')
        //     ->whereBetween('checked_at', [$req->tanggal_awal, $req->tanggal_akhir])
        //     ->where('asets.kode_jurusan', [$req->id_jurusan])
        //     ->where('asets.id_ruangan', [$req->id_ruangan])
        //     ->where('asets.id_jenis', [$req->id_jenis])
        //     ->get();
        // }
        
        return response()->json($req);


        // return Datatables::of($data)
        // ->addColumn('action', function ($data) {
        //     $btn = '<div class="btn-group">
        //         <button data-toggle="dropdown"
        //             class="btn btn-primary btn-sm dropdown-toggle">Action </button>
        //         <ul class="dropdown-menu">
        //             <li>
        //                 <a class="dropdown-item"
        //                     href="/detail_aset/' . Crypt::encrypt($data->id_aset) . '" target="_blank"> Detail</a>
        //             </li>
        //             <li>
        //                 <form action="/hapus_laporan" method="post">
        //                 <input type="hidden" name="_token" value="' . csrf_token() . '" />
        //                     <input type="hidden" name="id"
        //                         value="' . $data->id_laporan . '">
        //                     <button
        //                         style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
        //                         class="dropdown-item pb-2" type="submit"
        //                         onclick="return confirm(`Are you Sure`)">
        //                         Hapus</button>
        //                 </form>
        //             </li>
        //         </ul>
        //     </div>';
        //     return $btn;
        // })
        // ->editColumn('id_kondisi',function ($data){
        //     return '<p class="btn btn-' . $data->icon_kondisi . ' btn-sm"> ' . $data->nama_kondisi . ' </p>'; 
        // })
        // ->rawColumns(['id_kondisi','action'])->make(true);
    }


    //ADMIN

    
    public function tambah_laporan(Request $req)
    {
        // dd($req);

        $hasil = [
            'id_aset' => $req['id_aset'],
            'checked_at' => $req['checked_at'],
            'kondisi_laporan' => $req['id_kondisi']
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
