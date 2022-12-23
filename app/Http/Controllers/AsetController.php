<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\JenisAset;
use App\Models\Jurusan;
use App\Models\Kondisi;
use App\Models\Ruangan;
use App\Models\Sumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AsetController extends Controller
{

    public function chartByJenis(Request $req)
    {

        $data = DB::select('select kondisis.id_kondisi, kondisis.nama_kondisi, kondisis.warna_kondisi, asets.id_kondisi as kondisi_aset, COUNT(asets.id_kondisi) as jumlah_aset from kondisis left join asets on kondisis.id_kondisi = asets.id_kondisi where asets.id_jenis=? group by asets.id_kondisi ORDER BY kondisis.id_kondisi ASC',[$req->id_jenis]);


        // DB::table('kondisis')
        // ->leftJoin('asets', 'asets.id_kondisi', '=', 'kondisis.id_kondisi')
        // ->groupBy('asets.id_kondisi')
        // ->orderBy('kondisis.id_kondisi')
        // ->get();


        return response()->json($data);
        


        // ->select('kondisis.id_kondisi, kondisis.nama_kondisi, kondisis.warna_kondisi, COUNT(asets.id_kondisi) as jumlah_aset')
    }


    public function asetByRuangan(Request $req)
    {
        if ( $req->refresh == 1) {
            $data = DB::table('asets')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
            ->get();
        } else {
            $data = DB::table('asets')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
            ->where('asets.kode_jurusan', $req->id_jurusan)
            ->where('asets.id_ruangan', $req->id_ruangan)
            ->where('asets.id_jenis', $req->id_jenis)
            ->where('asets.id_kondisi', $req->id_kondisi)
            ->get();
        }
        
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
                            <a href="/qr_code/' . Crypt::encrypt($data->id_aset) . '"
                                class="dropdown-item" target="_blank">Generate QR Code</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                                href="/edit_aset/' . Crypt::encrypt($data->id_aset) . '">
                                Edit</a>
                        </li>
                        <li>
                            <form action="/hapus_aset" method="post">
                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <input type="hidden" name="id"
                                    value="' . $data->id_aset . '">
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

    public function asetById(Request $req)
    {
        $data = DB::select('SELECT asets.* FROM asets LEFT JOIN ruangans ON asets.id_ruangan = ruangans.id_ruangan WHERE asets.id_aset = ?', [$req->id_aset]);

        return response()->json($data);
    }


    public function list_aset()
    {
        $title = "Daftar Aset";
        $dataRuangan = Ruangan::all();
        $dataJenis = JenisAset::all();
        $dataJurusan = Jurusan::all();
        $dataKondisi = Kondisi::all();

        $dataAset = DB::table('asets')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
            ->get();

        return view("fitur.list_aset", compact("dataKondisi", "dataAset", "title", "dataRuangan", "dataJurusan", "dataJenis"));
    }

    public function tambah_aset(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['kode_aset' => 'required|unique:asets,kode_aset'],
            ['kode_aset.unique' => 'Kode aset telah tersedia!']
        );

        $hasil = [
            'kode_jurusan' => $req['kode_jurusan'],
            'id_ruangan' => $req['id_ruangan'],
            'id_jenis' => $req['id_jenis'],
            'kode_aset' => $req['kode_aset'],
            'nama_aset' => $req['nama_aset'],
            'tahun_pengadaan' => $req['tahun_pengadaan'],
            'nup' => $req['nup'],
            'merk_type' => $req['merk_type'],
            'jumlah' => $req['jumlah'],
            'nilai_barang' => $req['nilai_barang'],
            'id_kondisi' => $req['id_kondisi'],
            'keterangan' => $req['keterangan'],
            
        ];
        
        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-aset/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);

            $hasil['foto_aset'] = $filename;
        } else {
            $hasil['foto_aset'] = 'foto-aset/default.png';
        }

        Aset::create($hasil);
        return redirect('/list_aset')->with('success', 'Data Berhasil Ditambah');
    }


    public function hapus_aset(Request $req)
    {
        $data = Aset::findOrFail($req['id']);
        // dd($data['foto']);
        $data->delete();

        if (($data['foto_aset'] != 'foto-aset/default.png')) {
            Storage::delete('public/' . $data['foto_aset']);
        }

        return redirect('/list_aset')->with('success', 'Data Berhasil Dihapus');
    }

    public function tampil_edit_aset(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $title = "Edit Aset";
        $dataAset = Aset::findOrFail($id);
        // dd($dataAset);
        $dataJurusan = Jurusan::all();
        $dataRuangan = DB::table('ruangans')
        ->where('id_jurusan', $dataAset->kode_jurusan)
        ->get();

        $dataJenis = JenisAset::all();
        $dataKondisi = Kondisi::all();

        return view("fitur.edit_aset", compact("dataJurusan", "dataKondisi", "dataAset", "title", "dataRuangan","dataJenis"));
    }

    public function edit_aset(Request $req)
    {
        // dd($req);

        $data = Aset::findOrFail($req['id']);

        if ($data->kode_aset != $req['kode_aset']) {
            $this->validate(
                $req,
                ['kode_aset' => 'required|unique:asets,kode_aset'],
                ['kode_aset.unique' => 'Kode aset telah tersedia!']
            );
        }

        $hasil = [
            'kode_jurusan' => $req['kode_jurusan'],
            'id_ruangan' => $req['id_ruangan'],
            'id_jenis' => $req['id_jenis'],
            'kode_aset' => $req['kode_aset'],
            'nama_aset' => $req['nama_aset'],
            'tahun_pengadaan' => $req['tahun_pengadaan'],
            'nup' => $req['nup'],
            'merk_type' => $req['merk_type'],
            'jumlah' => $req['jumlah'],
            'nilai_barang' => $req['nilai_barang'],
            'id_kondisi' => $req['id_kondisi'],
            'keterangan' => $req['keterangan'], 
        ];

        // dd($req);
        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-aset/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);
            if (($req['fotoLama'] != 'foto-aset/default.png')) {
                Storage::delete('public/' . $req['fotoLama']);
            }

            $hasil['foto_aset'] = $filename;
        } else {
            $hasil['foto_aset'] = $req['fotoLama'];
        }

        Aset::all()->where('id_aset', $req['id'])->first()->update($hasil);

        return redirect('/edit_aset/' . Crypt::encrypt($req['id']))->with('success', 'Data Aset Diubah');
    }


    public function tampil_detail_aset(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $dataAset = DB::table('asets')
        ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
        ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
        ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
        ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
        ->where('asets.id_aset', $id)
        ->first();

        return view('fitur.detail_aset', [
            "data" => $dataAset,
            "url" => url('detail-aset/' . $req->id)
        ]);
    }


    public function qr_code(Request $req)
    { $id = Crypt::decrypt($req->id);

        $aset = Aset::findOrFail($id);
        
        return view('fitur.qr_code',[
            'aset' => $aset,
            'title' => 'QRcode',
            'data' => url('/detail_aset/'.$req->id)
        ]);

    }



}
