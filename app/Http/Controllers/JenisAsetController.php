<?php

namespace App\Http\Controllers;

use App\Models\JenisAset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisAsetController extends Controller
{
    public function list_jenis_aset() {
        $title = "Daftar Jenis Aset";
        $dataJenis = JenisAset::all();
        return view("fitur.list_jenisaset", compact("dataJenis","title"));
    }


    public function tambah_jenis_aset(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['nama_jenis' => 'required|unique:jenis_asets,nama_jenis'],
            ['nama_jenis.unique' => 'Nama jenis telah tersedia!']
        );

        $hasil = [
            'nama_jenis' => $req['nama_jenis'],
            'warna_jenis' => '#' . substr(Str::uuid(), 0, 6),
        ];

        JenisAset::create($hasil);
        return redirect('/list_jenis_aset')->with('success', 'Data Jenis Berhasil Ditambah');
    }


    public function edit_jenis_aset(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['nama_jenis' => 'required|unique:jenis_asets,nama_jenis'],
            ['nama_jenis.unique' => 'Nama jenis telah tersedia!']
        );


        JenisAset::all()->where('id_jenis', $req['id'])->first()->update([
            'nama_jenis' => $req['nama_jenis']
        ]);

        return redirect('/list_jenis_aset')->with('success', 'Data Jenis Berhasil Diubah');
    }


    public function hapus_jenis_aset(Request $req)
    {
        $data = JenisAset::findOrFail($req['id']);
        $data->delete();

        return redirect('/list_jenis_aset')->with('success', 'Data Berhasil Dihapus');
    }




}
