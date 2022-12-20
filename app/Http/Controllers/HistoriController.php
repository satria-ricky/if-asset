<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Histori;
use App\Models\HistoriRuangan;
use App\Models\Jurusan;
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

        $data = DB::select('SELECT historis.*, users.*, asets.*, asets.nama as nama_aset FROM historis LEFT JOIN users ON users.id = historis.id_user LEFT JOIN asets ON asets.id_aset = historis.id_aset WHERE users.id = ? AND historis.mulai BETWEEN ? AND ?', [$req->mahasiswa, $req->awal, $req->akhir]);
        // return response()->json($data);
        return Datatables::of($data)->editColumn('selesai', function ($data) {
            if ($data->selesai == '') {
                $selesai = '<p class="btn btn-warning btn-sm"> is being used
                </p>';
            } else {
                $selesai = $data->selesai;
            }
            return $selesai;
        })
            ->rawColumns(['selesai'])->make(true);
    }


    public function filterHistoriRuangan(Request $req)
    {


        if ($req->refresh == 1) {
            $data = DB::table('histori_ruangans')
                ->leftJoin('users', 'users.id', '=', 'histori_ruangans.id_user')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'histori_ruangans.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'histori_ruangans.id_ruangan')
                ->where('users.level', 4)
                ->get();
        } else {
            $data = DB::table('histori_ruangans')
                ->leftJoin('users', 'users.id', '=', 'histori_ruangans.id_user')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'histori_ruangans.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'histori_ruangans.id_ruangan')
                ->where('users.id', $req->id_user)
                ->whereBetween('mulai', [$req->tanggal_awal, $req->tanggal_akhir])
                ->where('histori_ruangans.kode_jurusan', [$req->id_jurusan])
                ->where('histori_ruangans.id_ruangan', [$req->id_ruangan])
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
                        <form action="/hapus_histori_ruangan" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '" />
                            <input type="hidden" name="id"
                                value="' . $data->id_histori_ruangan . '">
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
            ->editColumn('selesai', function ($data) {
                if ($data->selesai == '') {
                    return '<form action="/selesai_dipakai_ruangan" method="post">
                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                    <input type="hidden" value="' . $data->id_histori_ruangan . '"
                        name="id">
                    <button class="btn btn-danger btn-sm" type="submit"
                        onclick="return confirm(`Are you Sure`)"> Belum selesai </button>
                </form>';
                } else {
                    return '<p class="btn btn-success btn-sm"> Great :)
            </p>';
                }
            })
            ->rawColumns(['selesai', 'action'])->make(true);
    }


    //Mahasiswa
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

        return redirect('/histori_aset')->with('success', 'You did great :)');
    }



    public function selesai_dipakai_ruangan(Request $req)
    {
        // dd($req);
        HistoriRuangan::all()->where('id_histori_ruangan', $req['id'])->first()->update([
            'selesai' => Carbon::now()->toDateTimeString()
        ]);

        return redirect('/histori_ruangan')->with('success', 'You did great :)');
    }


    public function histori_ruangan()
    {
        $title = "Daftar Histori";
        $dataJurusan = Jurusan::all();
        $dataUser = DB::table('users')
            ->where('level', 4)
            ->get();

        if (Auth::user()->level == 1) {
            $dataHistori = DB::table('histori_ruangans')
                ->leftJoin('users', 'users.id', '=', 'histori_ruangans.id_user')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'histori_ruangans.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'histori_ruangans.id_ruangan')
                ->get();
        } elseif (Auth::user()->level == 2 || Auth::user()->level == 3) {
            return redirect('/');
        } elseif (Auth::user()->level == 4) {

            $dataHistori = DB::table('histori_ruangans')
                ->leftJoin('users', 'users.id', '=', 'histori_ruangans.id_user')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'histori_ruangans.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'histori_ruangans.id_ruangan')
                ->where('histori_ruangans.id_user', [Auth::user()->id])
                ->get();
        }


        // dd($dataHistori);
        return view("fitur.list_histori_ruangan", compact("dataHistori", "title", "dataJurusan", "dataUser"));
    }

    public function histori_aset()
    {
        $title = "Daftar Histori";
        $dataUser = DB::table('users')
            ->where('level', '!=', 1)
            ->where('level', '!=', 2)
            ->where('level', '!=', 4)
            ->get();

        if (Auth::user()->level == 1) {

            $dataHistori = DB::table('historis')
                ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
                ->leftJoin('users', 'users.id', '=', 'historis.id_user')
                ->where('users.level', '!=', 4)
                ->get();
        } elseif (Auth::user()->level == 2) {
            return redirect('/');
        } elseif (Auth::user()->level == 3 || Auth::user()->level == 4) {

            $dataHistori = DB::table('historis')
                ->leftJoin('asets', 'asets.id_aset', '=', 'historis.id_aset')
                ->leftJoin('users', 'users.id', '=', 'historis.id_user')
                ->where('historis.id_user', Auth::user()->id)
                ->get();
        }

        return view("fitur.list_histori", compact("dataHistori", "title", "dataUser"));
    }
}
