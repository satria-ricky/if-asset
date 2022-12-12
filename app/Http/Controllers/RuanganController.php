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
    public function list_ruangan() {
        $title = "Daftar Ruangan";
        $dataJurusan = Jurusan::all();
        $dataRuangan = Ruangan::all();
        return view("fitur.list_ruangan", compact("dataJurusan","dataRuangan","title"));
    }
    
    public function tambah_ruangan(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['nama_ruangan' => 'required|unique:ruangans,nama_ruangan'],
            ['nama_ruangan.unique' => 'Nama ruangan telah tersedia!']
        );

        $hasil = [
            'nama_ruangan' => $req['nama_ruangan'],
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
        // dd($req);
        $this->validate(
            $req,
            ['nama_ruangan' => 'required|unique:ruangans,nama_ruangan'],
            ['nama_ruangan.unique' => 'Nama ruangan telah tersedia!']
        );

        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-ruangan/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);

            if (($req['fotoLama'] != 'foto-ruangan/default.jpg')) {
                Storage::delete('public/' . $req['fotoLama']);
            }

            $hasil['foto_aset'] = $filename;
        } else {
            $hasil['foto_aset'] = $req['fotoLama'];
        }

        Ruangan::all()->where('id_ruangan', $req['id'])->first()->update([
            'nama_ruangan' => $req['nama_ruangan']
        ]);

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
    { $id = Crypt::decrypt($req->id);

        $ruangan = Ruangan::findOrFail($id);
        
        return view('fitur.qr_code_ruangan',[
            'ruangan' => $ruangan,
            'title' => 'QRcode',
            'data' => url('/detail_ruangan/'.$req->id)
        ]);

    }


    public function tampil_detail_ruangan(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $ruangan = Ruangan::findOrFail($id);

        return view('fitur.detail_ruangan', [
            "data" => $ruangan,
            "url" => url('detail_ruangan/' . $req->id)
        ]);
    }


}
