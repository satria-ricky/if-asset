<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Histori;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    public function list_histori() {
        $title = "Daftar Histori";
        $dataHistori = DB::table('historis')
            ->leftJoin('users', 'users.id', '=', 'historis.id_user')
            ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
            ->where('historis.id_user', [Auth::user()->id])
            ->get();
        // dd($dataHistori);
        return view("fitur.mhs.list_histori", compact("dataHistori","title"));
    }

    public function selesai_dipakai(Request $req)
    {
        // dd($req);
        Histori::all()->where('id_histori', $req['id'])->first()->update([
            'selesai' => Carbon::now()->toDateTimeString()
        ]);

        return redirect('/list_histori')->with('success', 'You did great :)');
    }


}
