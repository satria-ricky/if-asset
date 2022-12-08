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
        if (Auth::attempt($data)) { // true sekalian session field di users nanti bisa dipanggil via Auth
            // echo "Login Success";
            if (Auth::user()->level == 1) {
                return redirect('/list_ruangan');
            } 
            elseif (Auth::user()->level == 2) {
                return redirect('/list_laporan');
            }
            elseif (Auth::user()->level == 3) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/auth')->with('message', 'Username salah!');
            }
            elseif (Auth::user()->level == 4) {
                return redirect('/list_ruanganDsn');
            } 
        } else { // false
            //Login Fail
            return redirect('/auth')->with('message', 'Username atau password salah');
        }
    }



    //FROM QR CODE


    public function tampil_loginMhs(Request $request)
    {
        // dd($request->id_aset);
        $id_aset = Crypt::decrypt($request->id_aset);
        if (!Auth::user()) {
            return view('Auth.login_mhs', [
                'title' => 'Inventaris Aset PSTI-UNRAM',
                'id_aset' => $request->id_aset
            ]);
        } else {
            if (Auth::user()->level == 1 || Auth::user()->level == 2) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/auth')->with('message', 'Silahkan login kembali!');

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

    public function loginMhs(Request $request)
    {
        // dd($request);
        $id_aset = Crypt::decrypt($request->id_aset);

        $data = [
            'username'     => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        Auth::attempt($data);
        if (Auth::attempt($data)) { // true sekalian session field di users nanti bisa dipanggil via Auth
            // echo "Login Success";
            if (Auth::user()->level == 1 || Auth::user()->level == 2) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/authMhs')->with('message', 'Username salah!');
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
            return redirect('/authMhs/' . Crypt::encrypt($id_aset))->with('message', 'Username atau password salah');
        }
    }




    //LOGIN DOSEN
    public function tampil_loginDsn(Request $request)
    {
        // dd($request->id_aset);
        $id_ruangan = Crypt::decrypt($request->id_ruangan);
        if (!Auth::user()) {
            return view('Auth.login_mhs', [
                'title' => 'Inventaris Aset PSTI-UNRAM',
                'id_aset' => $request->id_ruangan
            ]);
        } else {
            if (Auth::user()->level == 1 || Auth::user()->level == 2) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/auth')->with('message', 'Silahkan login kembali!');

            } elseif (Auth::user()->level == 3) {
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




    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil Logout!');
    }
}
