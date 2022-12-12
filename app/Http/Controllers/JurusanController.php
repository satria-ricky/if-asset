<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function list_jurusan() {
        $title = "Daftar Jurusan";
        $dataJurusan = Jurusan::all();
        return view("fitur.list_jurusan", compact("dataJurusan","title"));
    }

    public function tambah_jurusan(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['nama_jurusan' => 'required|unique:jurusans,nama_jurusan'],
            ['nama_jurusan.unique' => 'Nama jurusan telah tersedia!']
        );

        $hasil = [
            'nama_jurusan' => $req['nama_jurusan'],
        ];

        Jurusan::create($hasil);
        return redirect('/list_jurusan')->with('success', 'Data Kode Jurusan Ditambah');
    }


    
}
