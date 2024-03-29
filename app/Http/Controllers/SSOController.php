<?php

namespace App\Http\Controllers;

use App\Helpers\AkademikHelper;
use App\Helpers\Helper;
use App\Helpers\MahasiswaHelper;
use App\Helpers\OperatorHelper;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SSOController extends Controller
{
    public function login(Request $request)
    {
        $_usso = Helper::_arr($request->all(), 'usso', array());
        $_info = Helper::_arr($_usso, 'info', array());
        $_login = Helper::_arr($_usso, 'login', array());
        $_level = Helper::_arr($_usso, 'level', array());

        $_signature = Helper::_arr($_usso, 'signature', time());
        $__akses = Helper::_arr($_level, 'kode_akses', time());

        // dd($request->all());
        if (Helper::_signature_verify($_signature, array($_login, $__akses), env('SSO_SECRET'))) {

            Session::put('info', $_info);
            Session::put('level', $_usso['level']['kode_akses']);


            // if ($_usso['level']['kode_view'] == 'M') {
            //     Session::put('info', $_info);
            //     Session::put('level', $_usso['level']);
            //     // Mahasiswa::updateOrCreate(
            //     //     ['NIM' => $_info['NIM']],
            //     //     Arr::except($_info, ['NIM', '_fields'])
            //     // );
            //     return response()->json([
            //         'status' => true,
            //         'redirect' => route("mahasiswa")
            //     ]);
            // } else 
            if ($_usso['level']['kode_akses'] == 'OP-FD') {
                Session::put('info', $_info);
                Session::put('level', $_usso['level']);
                User::updateOrCreate(
                    ['username' => $_info['kode']],
                    // 
                    [
                        'nama_user' => $_login['username'],
                        'username' => $_info['kode'],
                        'level' => 1
                    ]
                );
                $id = User::where('username', $_info['kode'])
                    ->select('id')
                    ->first();
                Auth::loginUsingId($id['id']);
                return response()->json([
                    'status' => true,
                    'redirect' => route("list_laporan")
                ]);
            } else if ($_usso['level']['kode_view'] == 'D') {
                if ($_info['kode_PS'] == '552011') {
                    Session::put('info', $_info);
                    Session::put('level', $_usso['level']);
                    User::updateOrCreate(
                        ['username' => $_info['kode']],
                        // 
                        [
                            'nama_user' => $_info['nama'],
                            'username' => $_info['kode'],
                            'level' => 1
                        ]
                    );
                    $id = User::where('username', $_info['kode'])
                        ->select('id')
                        ->first();
                    Auth::loginUsingId($id['id']);
                    return response()->json([
                        'status' => true,
                        'redirect' => route("list_laporan")
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'data' => 'Kode akses tidak dikenalkan.',
                        'request' => $_usso

                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'data' => 'Kode akses tidak dikenal.',
                    'request' => $_usso['level']
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'data' => $request->all(),
                'redirect' => route("home"),
            ]);
        }
    }

    public function logout()
    {
        //cek
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function logout_sso()
    {
        //cek
        return redirect(env('SSO_NAME') . '?logout');
    }
}
