<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function list_ruangan() {
        $loc = "list_ruangan";
        $title = "Daftar Ruangan";
        $dataRuangan = Ruangan::all();
        return view("fitur.list_ruangan", compact("loc","dataRuangan","title"));
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

        Ruangan::all()->where('id_ruangan', $req['id'])->first()->update([
            'nama_ruangan' => $req['nama_ruangan']
        ]);

        return redirect('/list_ruangan')->with('success', 'Data Ruangan Diubah');
    }

    public function hapus_ruangan(Request $req)
    {
        $data = Ruangan::findOrFail($req['id']);
        $data->delete();

        return redirect('/list_ruangan')->with('success', 'Data Berhasil Dihapus');
    }


}
