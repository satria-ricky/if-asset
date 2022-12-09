<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Histori;
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
        return view('Auth.home', [
            'title' => 'Inventaris Aset PSTI-UNRAM'
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
                return redirect('/list_histori');
            } elseif (Auth::user()->level == 4) {
                return redirect('/list_historiDsn');
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
            } 
            elseif (Auth::user()->level == 2) {
                return redirect('/list_laporan');
            }
            elseif (Auth::user()->level == 3) {
                return redirect('/list_histori');
            }
            elseif (Auth::user()->level == 4) {
                return redirect('/list_historiDsn');
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

                return redirect('/authAset/'.$request->id_aset)->with('message', 'Silahkan login kembali!');

            } elseif (Auth::user()->level == 3) {
                $checkHistori = DB::table('historis')
                    ->where('id_user', Auth::user()->id)
                    ->where('id_aset', $id_aset)
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
                    return redirect('/list_histori')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/list_histori')->with('warning', 'Anda masih menggunakannya :(');
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

                return redirect('/authAset/'.$request->id_aset)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 3) {

                $checkHistori = DB::table('historis')
                    ->where('id_user', Auth::user()->id)
                    ->where('id_aset', $id_aset)
                    ->whereNull('selesai')
                    ->first();

                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'id_aset' => $id_aset,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    Histori::create($hasil);
                    return redirect('/list_histori')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/list_histori')->with('warning', 'Anda masih menggunakannya :(');
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
        // dd($request->id_aset);
        $id_ruangan = Crypt::decrypt($request->id_ruangan);
        if (!Auth::user()) {
            return view('Auth.login_ruangan', [
                'title' => 'Inventaris Aset PSTI-UNRAM',
                'id_ruangan' => $request->id_ruangan
            ]);
        } else {
            if (Auth::user()->level == 1 || Auth::user()->level == 2|| Auth::user()->level == 3) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authRuangan/'.$request->id_ruangan)->with('message', 'Username salah!');

            } elseif (Auth::user()->level == 4) {
                $checkHistori = DB::table('historis')
                    ->where('id_user', Auth::user()->id)
                    ->where('id_aset', $id_ruangan)
                    ->whereNull('selesai')
                    ->first();
                // dd($checkHistori);
                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'id_aset' => $id_ruangan,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    Histori::create($hasil);
                    return redirect('/list_histori')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/list_histori')->with('warning', 'Anda masih menggunakannya :(');
                }
            }
        }
    }

    public function loginRuangan(Request $request)
    {
        // dd($request);
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

                return redirect('/authRuangan/'.$request->id_ruangan)->with('message', 'Username salah!');
            } elseif (Auth::user()->level == 3) {

                $checkHistori = DB::table('histori_ruangans')
                    ->where('id_user', Auth::user()->id)
                    ->where('id_ruangan', $id_ruangan)
                    ->whereNull('selesai')
                    ->first();
                dd($checkHistori);
                
                if ($checkHistori == null) {
                    $hasil = [
                        'id_user' => Auth::user()->id,
                        'id_ruangan' => $id_ruangan,
                        'mulai' => Carbon::now()->toDateTimeString()
                    ];

                    Histori::create($hasil);
                    return redirect('/list_histori')->with('success', 'Histori berhasil ditambah :)');
                } else {
                    return redirect('/list_histori')->with('warning', 'Anda masih menggunakannya :(');
                }
            }
        } else { // false
            //Login Fail
            return redirect('/authRuangan/' . Crypt::encrypt($id_ruangan))->with('message', 'Username salah');
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
