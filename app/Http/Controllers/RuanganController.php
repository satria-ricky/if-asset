<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{

    public function getRuanganByJurusan(Request $req){
        // $data = DB::table('ruangans')
        // ->leftJoin('jurusans', 'jurusans.id_jurusan','=','ruangans.id_jurusan')
        // ->where('ruangans.id_jurusan',$req->id_jurusan)
        // ->get();

        return response()->json($req->id_jurusan);
    }

    public function list_ruangan()
    {
        $title = "Daftar Ruangan";
        $dataJurusan = Jurusan::all();
        $dataRuangan = DB::table('ruangans')
            ->leftJoin('jurusans', 'jurusans.id_jurusan','=','ruangans.id_jurusan')
            ->get();

        return view("fitur.list_ruangan", compact("dataJurusan", "dataRuangan", "title"));
    }

    public function tambah_ruangan(Request $req)
    {

        $cekRuangan = DB::table('ruangans')
            ->where('id_jurusan', $req['id_jurusan'])
            ->where('nama_ruangan', $req['nama_ruangan'])
            ->first();
        // dd($cekRuangan);
        if ($cekRuangan != null) {
            return redirect('/list_ruangan')->with('error', 'Nama ruangan telah tersedia!');
        }
        
        $hasil = [
            'id_jurusan' => $req['id_jurusan'],
            'nama_ruangan' => $req['nama_ruangan']
        ];

        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-ruangan/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);

            $hasil['foto_ruangan'] = $filename;
        } else {
            $hasil['foto_ruangan'] = 'foto-ruangan/default.jpg';
        }

        Ruangan::create($hasil);
        return redirect('/list_ruangan')->with('success', 'Data Ruangan Ditambah');
    }


    public function edit_ruangan(Request $req)
    {
        $cekRuangan = DB::table('ruangans')
        ->where('id_jurusan', $req['id_jurusan'])
        ->where('nama_ruangan', $req['nama_ruangan'])
        ->where('id_ruangan','!=', $req['id'])
        ->first();
        // dd($cekRuangan);
        if ($cekRuangan != null) {
            return redirect('/list_ruangan')->with('error', 'Nama ruangan telah tersedia!');
        }

        $hasil = [
            'id_jurusan' => $req['id_jurusan'],
            'nama_ruangan' => $req['nama_ruangan']
        ];

        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-ruangan/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);

            if (($req['fotoLama'] != 'foto-ruangan/default.jpg')) {
                Storage::delete('public/' . $req['fotoLama']);
            }

            $hasil['foto_ruangan'] = $filename;
        } else {
            $hasil['foto_ruangan'] = $req['fotoLama'];
        }

        Ruangan::all()->where('id_ruangan', $req['id'])->first()->update($hasil);

        return redirect('/list_ruangan')->with('success', 'Data Ruangan Diubah');
    }

    public function hapus_ruangan(Request $req)
    {
        $data = Ruangan::findOrFail($req['id']);
        $data->delete();
        if (($data['foto_ruangan'] != 'foto-ruangan/default.jpg')) {
            Storage::delete('public/' . $data['foto_ruangan']);
        }

        return redirect('/list_ruangan')->with('success', 'Data Berhasil Dihapus');
    }

    public function qr_code(Request $req)
    {
        $id = Crypt::decrypt($req->id);

        $ruangan =DB::table('ruangans')
        ->leftJoin('jurusans','jurusans.id_jurusan', '=', 'ruangans.id_jurusan')
        ->where('id_ruangan', $id)
        ->first();


        return view('fitur.qr_code_ruangan', [
            'ruangan' => $ruangan,
            'title' => 'QRcode Ruangan',
            'data' => url('/detail_ruangan/' . $req->id)
        ]);
    }


    public function tampil_detail_ruangan(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $ruangan = DB::table('ruangans')
        ->leftJoin('jurusans','jurusans.id_jurusan', '=', 'ruangans.id_jurusan')
        ->where('id_ruangan', $id)
        ->first();
        
        return view('fitur.detail_ruangan', [
            "data" => $ruangan,
            "url" => url('detail_ruangan/' . $req->id)
        ]);
    }
}
