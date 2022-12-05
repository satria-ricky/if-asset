<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function tampil_profil()
    {
        $title = "Inventaris Aset PSTI-UNRAM";
        return view('fitur.profil',[
            'title' => $title
        ]);
    }

    public function tampil_home()
    {
        return view('Auth.home',[
            'title' => 'Inventaris Aset PSTI-UNRAM'
        ]);
    }

    public function tampil_login()
    {
        if (!Auth::user()) {
            return view('Auth.login',[
                'title' => 'Inventaris Aset PSTI-UNRAM'
            ]);
        } else {
            if (Auth::user()->level == 1) {
                return redirect('/list_ruangan');
            } elseif (Auth::user()->level == 2) {
                return redirect('/list_laporan');
            }elseif (Auth::user()->level == 3) {
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
            } elseif(Auth::user()->level == 2) {
                return redirect('/list_laporan');
            } elseif(Auth::user()->level == 3) {
                return redirect('/list_histori');
            }
        
        } else { // false
            //Login Fail
            return redirect('/auth')->with('message', 'Username atau password salah');
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
