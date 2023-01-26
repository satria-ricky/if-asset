<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Carbon\Carbon;
use App\Models\Histori;
use App\Models\HistoriRuangan;
use App\Models\JenisAset;
use App\Models\Kondisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function tampil_profil()
    {
        $title = "Inventaris Aset PSTI-UNRAM";
        return view('fitur.profil', [
            'title' => $title
        ]);
    }


    public function tampil_home()
    {
        $dataJenis = JenisAset::all();
        $dataKondisi = Kondisi::all();

        // SELECT jenis_asets.nama_jenis, COUNT(asets.id_kondisi) as jumlah_aset FROM tb_subbidang LEFT JOIN tb_keluar ON tb_subbidang.sub_id = tb_keluar.id_subbidang_keluar GROUP BY sub_id_bidang ORDER BY sub_id_bidang ASC
        
        $data = DB::select('SELECT jenis_asets.nama_jenis, SUM(jumlah) as jumlah, tahun_pengadaan FROM `asets` LEFT JOIN jenis_asets ON asets.id_jenis = jenis_asets.id_jenis GROUP by asets.id_jenis, tahun_pengadaan order by tahun_pengadaan;');

        $jenis = DB::select('SELECT DISTINCT(jenis_asets.nama_jenis) FROM `asets` join jenis_asets on jenis_asets.id_jenis = asets.id_jenis ;');

        $tahun = array();

        // dd($jenis);
        $index =0;
        $re = [];
        foreach($jenis as $isi) { 
            // dd($isi->nama_jenis);
            
            $re[ $isi->nama_jenis] = [];
            
        }

        // dd($re);
        
        foreach($data as $item) {
            if(!in_array($item->tahun_pengadaan, $tahun)){
                array_push($tahun,$item->tahun_pengadaan);
                // dd($re[0]['Elektronik']);
                foreach ($jenis as $jn) {
                    if ($item->nama_jenis == $jn->nama_jenis) {
                        array_push($re[$jn->nama_jenis], $item->jumlah);
                        // break;
                    } else {
                        array_push($re[$jn->nama_jenis], 0);
                    }
                    
                }
                
            } else {
                foreach ($jenis as $jn) {

                    if ($item->nama_jenis == $jn->nama_jenis) {
                        $re[$jn->nama_jenis][count($re[$jn->nama_jenis])-1] = $item->jumlah;
                        // break;
                    } 
                    
                }
            }
        } 

        // 
        // $re['jenis_aset'] = DB::select('SELECT nama_jenis,warna_jenis FROM jenis_asets');
        // dd($re);
        // $array = json_encode($re, true);
        // return $array;
        // return $re;
        $data = [];
        foreach ($re as $i => $a){
            array_push($data,['label' => $i, 'data' => $a]);
        }
        // dd($data);


        return view('Auth.home', [
            'title' => 'Inventaris Aset PSTI-UNRAM',
            'dataJenis' => $dataJenis,
            'dataKondisi' => $dataKondisi,
            'data' =>  $data,
            'tahun' =>  $tahun,
        ]);
    }

    public function tampil_login()
    {
        if (!Auth::user()) {
            return view('Auth.login', [
                'title' => 'Inventaris Aset PSTI-UNRAM'
            ]);
        } else {
            if (Auth::user()->level == 1) {
                return redirect('/list_ruangan');
            } elseif (Auth::user()->level == 2) {
                return redirect('/list_laporan');
            } elseif (Auth::user()->level == 3) {
                return redirect('/histori_aset');
            } elseif (Auth::user()->level == 4) {
                return redirect('/histori_ruangan');
            }
        }
    }

    public function login(Request $request)
    {
        $data = [
            'username'     => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        Auth::attempt($data);
        // dd(Auth::user());
        // echo Auth::user()->username;
        if (Auth::attempt($data)) {
            if (Auth::user()->level == 1) {
                return redirect('/list_ruangan');
            } elseif (Auth::user()->level == 2) {
                return redirect('/list_laporan');
            } elseif (Auth::user()->level == 3) {
                return redirect('/histori_aset');
            } elseif (Auth::user()->level == 4) {
                return redirect('/histori_ruangan');
            }
        } else { // false
            //Login Fail
            return redirect('/auth')->with('message', 'Username salah');
        }
    }



    //FROM QR CODE


    public function tampil_loginAset(Request $request)
    {
        // dd($request->id_aset);
        $id_aset = Crypt::decrypt($request->id_aset);
        if (!Auth::user()) {
            return view('Auth.login_aset', [
                'title' => 'Inventaris Aset PSTI-UNRAM',
                'id_aset' => $request->id_aset
            ]);
        } else {
            if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 4) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authAset/' . $request->id_aset)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 3) {
                $checkHistori = DB::table('historis')
                    ->where('id_aset', $id_aset)
                    ->where('id_user', Auth::user()->id)
                    ->whereNull('selesai')
                    ->first();
                // dd($checkHistori);
                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'id_aset' => $id_aset,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    Histori::create($hasil);
                    return redirect('/histori_aset')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/histori_aset')->with('warning', 'Masih digunakan :(');
                }
            }
        }
    }

    public function loginAset(Request $request)
    {
        // dd($request);
        $id_aset = Crypt::decrypt($request->id_aset);

        $data = [
            'username'     => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        Auth::attempt($data);
        if (Auth::attempt($data)) {
            if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 4) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authAset/' . $request->id_aset)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 3) {

                $checkHistori = DB::table('historis')
                    ->where('id_aset', $id_aset)
                    ->where('id_user', Auth::user()->id)
                    ->whereNull('selesai')
                    ->first();

                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'id_aset' => $id_aset,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    Histori::create($hasil);
                    return redirect('/histori_aset')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/histori_aset')->with('warning', 'Masih digunakan:(');
                }
            }
        } else { // false
            //Login Fail
            return redirect('/authAset/' . Crypt::encrypt($id_aset))->with('message', 'Username salah');
        }
    }




    //LOGIN DOSEN
    public function tampil_loginRuangan(Request $request)
    {
        // dd("ini jurusan : ".$request->id_jurusan." --- ini ruangan : ".$request->id_ruangan);
        $id_jurusan = Crypt::decrypt($request->id_jurusan);
        $id_ruangan = Crypt::decrypt($request->id_ruangan);
        if (!Auth::user()) {
            return view('Auth.login_ruangan', [
                'title' => 'Inventaris Aset PSTI-UNRAM',
                'id_jurusan' => $request->id_jurusan,
                'id_ruangan' => $request->id_ruangan
            ]);
        } else {
            if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 3) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authRuangan/' . $request->id_jurusan . '/' . $request->id_ruangan)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 4) {
                $checkHistori = DB::table('histori_ruangans')
                    ->where('histori_ruangans.kode_jurusan', $id_jurusan)
                    ->where('histori_ruangans.id_ruangan', $id_ruangan)
                    ->whereNull('selesai')
                    ->first();
                // dd($checkHistori);
                if ($checkHistori == null) {

                    $getAsetbyRuangan = DB::table('asets')
                        ->where('id_ruangan', $id_ruangan)
                        ->get();
                    // ddd($getAsetbyRuangan);

                    foreach ($getAsetbyRuangan as $item) {
                        $hasilAset = [
                            'id_user' => Auth::user()->id,
                            'id_aset' => $item->id_aset,
                            'mulai' => Carbon::now()->toDateTimeString()
                        ];
                        Histori::create($hasilAset);
                    }


                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'kode_jurusan' => $id_jurusan,
                        'id_ruangan' => $id_ruangan,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    HistoriRuangan::create($hasil);
                    return redirect('/histori_ruangan')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/histori_ruangan')->with('warning', ' Masih digunakan :(');
                }
            }
        }
    }

    public function loginRuangan(Request $request)
    {
        // dd($request);
        $id_jurusan = Crypt::decrypt($request->id_jurusan);
        $id_ruangan = Crypt::decrypt($request->id_ruangan);

        $data = [
            'username'     => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        Auth::attempt($data);
        if (Auth::attempt($data)) {

            if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 3) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authRuangan/' . $request->id_jurusan . '/' . $request->id_ruangan)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 4) {

                $checkHistori = DB::table('histori_ruangans')
                    ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'histori_ruangans.id_ruangan')
                    ->where('histori_ruangans.kode_jurusan', $id_jurusan)
                    ->where('histori_ruangans.id_ruangan', $id_ruangan)
                    ->whereNull('histori_ruangans.selesai')
                    ->first();
                // dd($checkHistori);

                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'kode_jurusan' => $id_jurusan,
                        'id_ruangan' => $id_ruangan,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    HistoriRuangan::create($hasil);
                    return redirect('/histori_ruangan')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/histori_ruangan')->with('warning', 'Masih digunakan :(');
                }
            }
        } else { // false
            //Login Fail
            return redirect('/authRuangan/' . Crypt::encrypt($id_jurusan) . '/' . Crypt::encrypt($id_ruangan))->with('message', 'Username salah');
        }
    }




    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil Logout!');
    }
}
