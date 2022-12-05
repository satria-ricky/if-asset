<?php

namespace App\Http\Controllers;

use App\Models\Aset;
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

    public function asetByRuangan(Request $req)
    {
        $data = DB::select('SELECT asets.* FROM asets LEFT JOIN ruangans ON asets.id_ruangan = ruangans.id_ruangan WHERE asets.id_ruangan = ?', [$req->id_ruangan]);

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
            ->rawColumns(['action'])->make(true);
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
        $dataAset = Aset::all();
        $dataSumber = Sumber::all();
        $dataKondisi = Kondisi::all();
        return view("fitur.list_aset", compact("dataKondisi", "dataAset", "title", "dataRuangan", "dataSumber"));
    }

    public function tambah_aset(Request $req)
    {

        $this->validate(
            $req,
            ['kode' => 'required|unique:asets,kode_aset'],
            ['kode.unique' => 'Kode aset telah tersedia!']
        );

        $hasil = [
            'id_sumber' => $req['idSumber'],
            'id_ruangan' => $req['idRuangan'],
            'kode_aset' => $req['kode'],
            'nama' => $req['nama'],
            'jumlah' => $req['jumlah'],
            'lokasi' => $req['lokasi'],
            'kondisi' => $req['kondisi'],
            'tahun_pengadaan' => $req['tahun_pengadaan']
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

        $dataAset = Aset::findOrFail($id);
        // dd($dataAset);
        $title = "Edit Aset";
        $dataRuangan = Ruangan::all();
        $dataKondisi = Kondisi::all();
        $dataSumber = Sumber::all();

        return view("fitur.edit_aset", compact("dataSumber", "dataKondisi", "dataAset", "title", "dataRuangan"));
    }

    public function edit_aset(Request $req)
    {

        $data = Aset::findOrFail($req['id']);

        if ($data->kode_aset != $req['kode']) {
            $this->validate(
                $req,
                ['kode' => 'required|unique:asets,kode_aset'],
                ['kode.unique' => 'Kode aset telah tersedia!']
            );
        }

        $hasil = [
            'id_sumber' => $req['idSumber'],
            'id_ruangan' => $req['idRuangan'],
            'kode_aset' => $req['kode'],
            'nama' => $req['nama'],
            'jumlah' => $req['jumlah'],
            'lokasi' => $req['lokasi'],
            'kondisi' => $req['kondisi'],
            'tahun_pengadaan' => $req['tahun_pengadaan']
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
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('sumbers', 'sumbers.id_sumber', '=', 'asets.id_sumber')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.kondisi')
            ->where('asets.id_aset', $id)
            ->first();

        return view('fitur.detail_aset', [
            "data" => $dataAset,
            "url" => url('detail-aset/' . $req->id)
        ]);
    }
}
