<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Histori;
use App\Models\Kondisi;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HistoriController extends Controller
{

    public function filterHistori(Request $req)
    {

        // $data = DB::select('SELECT historis.*, users.*, asets.* FROM historis LEFT JOIN users ON users.id = historis.id_user LEFT JOIN asets ON asets.id_aset = historis.id_aset WHERE users.id = ? AND historis.mulai BETWEEN ? AND ?', [$req->mahasiswa,$req->awal,$req->akhir]);
        // DB::table('historis')
        //     ->leftJoin('users', 'users.id', '=', 'historis.id_user')
        //     ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
        //     ->whereBetween('mulai', [$req->awal, $req->akhir])
        //     ->where('users.id', [$req->mahasiswa])
        //     ->select('historis.*','users.*','asets.*')->get();

            return response()->json($req);
        // return Datatables::of($data)->make(true);
    }

    public function list_histori()
    {
        $title = "Daftar Histori";
        $dataHistori = DB::table('historis')
            ->leftJoin('users', 'users.id', '=', 'historis.id_user')
            ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
            ->where('historis.id_user', [Auth::user()->id])
            ->get();
        // dd($dataHistori);
        return view("fitur.mhs.list_histori", compact("dataHistori", "title"));
    }

    public function selesai_dipakai(Request $req)
    {
        // dd($req);
        Histori::all()->where('id_histori', $req['id'])->first()->update([
            'selesai' => Carbon::now()->toDateTimeString()
        ]);

        return redirect('/list_histori')->with('success', 'You did great :)');
    }


    //ADMIN
    public function adm_histori()
    {
        $title = "Daftar Histori";
        $dataUser = DB::table('users')
            ->where('level', '!=', 1)
            ->where('level', '!=', 2)
            ->get();

        $dataHistori = DB::table('historis')
            ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
            ->leftJoin('users', 'users.id', '=', 'historis.id_user')
            ->get();
        // dd($dataLaporan);
        return view("fitur.adm_histori", compact("dataHistori", "title", "dataUser"));
    }
}
