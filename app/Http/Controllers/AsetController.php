<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Sumber;
use GuzzleHttp\Client;
use App\Models\Jurusan;
use App\Models\Kondisi;
use App\Models\Ruangan;
use App\Models\JenisAset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use LDAP\Result;

class AsetController extends Controller
{

    function getPrasarana($check, $id)
    {
        $client = new Client();

        if ($check == 'all') {
            $response = $client->request('GET', 'https://prasarana.unram.ac.id/index.php/api/sia/ruang?number=-1&__csrf=P25sigHhPqKyeo');
        } elseif ($check == 'jurusan') {
            $response = $client->request('GET', 'https://prasarana.unram.ac.id/index.php/api/sia/ruang?fakultas_kode=' . $id . '&number=-1&__csrf=P25sigHhPqKyeo');
        }

        // Get the response body as a string
        $data = $response->getBody()->getContents();
        // dd(json_decode($data));
        return $data;
        
        // return $result;
// $tampung = [];
//         foreach ($result as $element) {
//             // echo $element->fakultas_kode;
//             if (in_array($element->fakultas_kode, $tampung)) {}
//             else{
//                 $tampung[] = [
//                     'fakultas_kode' => $element->fakultas_kode,
//                     '_fakultas_nama' => $element->_fakultas_nama,
//                 ];
//             }
//         }

//         return $tampung;
        // $idColumn = array_map(function ($item) {

        //     $result[] = [
        //         'kode_fakultas' => $item->fakultas_kode,
        //         '_fakultas_nama' => $item->_fakultas_nama,
        //     ];

        // }, $array);

    
        // $response = new Response($distinctIdColumn);


        // $distinctIdColumn = json_encode($distinctIdColumn);
        // return $distinctIdColumn;
    }


    public function chartByJenis(Request $req)
    {

        $data = DB::select('select kondisis.id_kondisi, kondisis.nama_kondisi, kondisis.warna_kondisi, asets.id_kondisi as kondisi_aset, COUNT(asets.id_kondisi) as jumlah_aset from kondisis left join asets on kondisis.id_kondisi = asets.id_kondisi where asets.id_jenis=? group by asets.id_kondisi ORDER BY kondisis.id_kondisi ASC', [$req->id_jenis]);

        $dataKondisi = Kondisi::all();

        return response()->json([
            'data' => $data,
            'dataKondisi' => $dataKondisi,

        ]);
    }

    public function chartAllAset()
    {
        $data = DB::select('select kondisis.id_kondisi, kondisis.nama_kondisi, kondisis.warna_kondisi, asets.id_kondisi as kondisi_aset, COUNT(asets.id_kondisi) as jumlah_aset from kondisis left join asets on kondisis.id_kondisi = asets.id_kondisi group by asets.id_kondisi ORDER BY kondisis.id_kondisi ASC');

        $dataKondisi = Kondisi::all();

        return response()->json([
            'data' => $data,
            'dataKondisi' => $dataKondisi,
        ]);
    }


    public function BarChartDataAset()
    {
        $data = DB::select('select asets.tahun_pengadaan, jenis_asets.id_jenis, jenis_asets.nama_jenis,jenis_asets.warna_jenis, SUM(asets.jumlah) as jumlah_aset FROM asets LEFT JOIN jenis_asets ON jenis_asets.id_jenis = asets.id_jenis GROUP BY asets.id_jenis, asets.tahun_pengadaan ORDER BY asets.tahun_pengadaan');


        // dd($data);
        $tahun = Array();
        $a = Array();
        $b = Array();
        $c = Array();
        foreach($data as $item) {
            // dd($item->tahun_pengadaan);
            // echo 
            if (!in_array($item->tahun_pengadaan,$tahun)) {
                array_push($tahun,$item->tahun_pengadaan);
                if ($item->id_jenis ==1) {
                    
                        array_push($a,$item->jumlah_aset);

                        array_push($b,0);
                        array_push($c,0);

                }if ($item->id_jenis ==2) {
                    array_push($a,0);
                    array_push($b,$item->jumlah_aset);
                    array_push($c,0);
                }if ($item->id_jenis ==3) {
                    array_push($a,$item->jumlah_aset);
                        array_push($b,0);
                        array_push($c,0);
                }
            } else {
                if ($item->id_jenis ==1) {
                    $a[count($a)-1] = $item->jumlah_aset;

            }if ($item->id_jenis ==2) {
                $b[count($b)-1] = $item->jumlah_aset;
            }if ($item->id_jenis ==3) {
                $c[count($c)-1] = $item->jumlah_aset;
            }
            }
        } 
        $isi['a'] = $a;
        $isi['b'] = $b;
        $isi['c'] = $c;

        dd($isi);
        
        return response()->json([
            'data' => $data
        ]);
    }


    public function asetByRuangan(Request $req)
    {
        if ($req->refresh == 1) {
            $data = DB::table('asets')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
                ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
                ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
                ->get();
        } else {
            $data = DB::table('asets')
                ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
                ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
                ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
                ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
                ->where('asets.kode_jurusan', $req->id_jurusan)
                ->where('asets.id_ruangan', $req->id_ruangan)
                ->where('asets.id_jenis', $req->id_jenis)
                ->where('asets.id_kondisi', $req->id_kondisi)
                ->get();
        }

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $btn = '<div class="btn-group">
                    <button data-toggle="dropdown"
                        class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                                href="/detail_aset/' . Crypt::encrypt($data->id_aset) . '" target="_blank"> Detail</a>
                        </li>
                        <li>
                            <a href="/qr_code/' . Crypt::encrypt($data->id_aset) . '"
                                class="dropdown-item" target="_blank">Generate QR Code</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                                href="/edit_aset/' . Crypt::encrypt($data->id_aset) . '">
                                Edit</a>
                        </li>
                        <li>
                            <form action="/hapus_aset" method="post">
                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <input type="hidden" name="id"
                                    value="' . $data->id_aset . '">
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
            ->editColumn('id_kondisi', function ($data) {
                return '<p class="btn btn-' . $data->icon_kondisi . ' btn-sm"> ' . $data->nama_kondisi . ' </p>';
            })
            ->rawColumns(['id_kondisi', 'action'])->make(true);
    }

    public function asetById(Request $req)
    {
        $data = DB::select('SELECT asets.* FROM asets LEFT JOIN ruangans ON asets.id_ruangan = ruangans.id_ruangan WHERE asets.id_aset = ?', [$req->id_aset]);

        return response()->json($data);
    }


    public function list_aset()
    {
        $title = "Daftar Aset";
        $dataRuangan = Ruangan::all();
        $dataJenis = JenisAset::all();
        // $dataJurusan = AsetController::getPrasarana('all', 0);
        $dataJurusan = Jurusan::all();
        // dd($dataJurusan);
        $dataKondisi = Kondisi::all();

        // dd($dataJurusan);
        $dataAset = DB::table('asets')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
            ->get();

        return view("fitur.list_aset", compact("dataKondisi", "dataAset", "title", "dataRuangan", "dataJurusan", "dataJenis"));
    }

    public function tambah_aset(Request $req)
    {
        // dd($req);
        $this->validate(
            $req,
            ['kode_aset' => 'required|unique:asets,kode_aset'],
            ['kode_aset.unique' => 'Kode aset telah tersedia!']
        );

        $hasil = [
            'kode_jurusan' => $req['kode_jurusan'],
            'id_ruangan' => $req['id_ruangan'],
            'id_jenis' => $req['id_jenis'],
            'kode_aset' => $req['kode_aset'],
            'nama_aset' => $req['nama_aset'],
            'tahun_pengadaan' => $req['tahun_pengadaan'],
            'nup' => $req['nup'],
            'merk_type' => $req['merk_type'],
            'jumlah' => $req['jumlah'],
            'nilai_barang' => $req['nilai_barang'],
            'id_kondisi' => $req['id_kondisi'],
            'keterangan' => $req['keterangan'],

        ];

        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-aset/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);

            $hasil['foto_aset'] = $filename;
        } else {
            $hasil['foto_aset'] = 'foto-aset/default.png';
        }

        Aset::create($hasil);
        return redirect('/list_aset')->with('success', 'Data Berhasil Ditambah');
    }


    public function hapus_aset(Request $req)
    {
        $data = Aset::findOrFail($req['id']);
        // dd($data['foto']);
        $data->delete();

        if (($data['foto_aset'] != 'foto-aset/default.png')) {
            Storage::delete('public/' . $data['foto_aset']);
        }

        return redirect('/list_aset')->with('success', 'Data Berhasil Dihapus');
    }

    public function tampil_edit_aset(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $title = "Edit Aset";
        $dataAset = Aset::findOrFail($id);
        // dd($dataAset);
        $dataJurusan = Jurusan::all();
        $dataRuangan = DB::table('ruangans')
            ->where('id_jurusan', $dataAset->kode_jurusan)
            ->get();

        $dataJenis = JenisAset::all();
        $dataKondisi = Kondisi::all();

        return view("fitur.edit_aset", compact("dataJurusan", "dataKondisi", "dataAset", "title", "dataRuangan", "dataJenis"));
    }

    public function edit_aset(Request $req)
    {
        // dd($req);

        $data = Aset::findOrFail($req['id']);

        if ($data->kode_aset != $req['kode_aset']) {
            $this->validate(
                $req,
                ['kode_aset' => 'required|unique:asets,kode_aset'],
                ['kode_aset.unique' => 'Kode aset telah tersedia!']
            );
        }

        $hasil = [
            'kode_jurusan' => $req['kode_jurusan'],
            'id_ruangan' => $req['id_ruangan'],
            'id_jenis' => $req['id_jenis'],
            'kode_aset' => $req['kode_aset'],
            'nama_aset' => $req['nama_aset'],
            'tahun_pengadaan' => $req['tahun_pengadaan'],
            'nup' => $req['nup'],
            'merk_type' => $req['merk_type'],
            'jumlah' => $req['jumlah'],
            'nilai_barang' => $req['nilai_barang'],
            'id_kondisi' => $req['id_kondisi'],
            'keterangan' => $req['keterangan'],
        ];

        // dd($req);
        if ($req->file('foto')) {
            $extension = $req->file('foto')->getClientOriginalExtension();
            $filename = 'foto-aset/' . uniqid() . '.' . $extension;
            $req->file('foto')->storeAs('public', $filename);
            if (($req['fotoLama'] != 'foto-aset/default.png')) {
                Storage::delete('public/' . $req['fotoLama']);
            }

            $hasil['foto_aset'] = $filename;
        } else {
            $hasil['foto_aset'] = $req['fotoLama'];
        }

        Aset::all()->where('id_aset', $req['id'])->first()->update($hasil);

        return redirect('/edit_aset/' . Crypt::encrypt($req['id']))->with('success', 'Data Aset Diubah');
    }


    public function tampil_detail_aset(Request $req)
    {
        $id = Crypt::decrypt($req->id);
        $dataAset = DB::table('asets')
            ->leftJoin('jurusans', 'jurusans.id_jurusan', '=', 'asets.kode_jurusan')
            ->leftJoin('ruangans', 'ruangans.id_ruangan', '=', 'asets.id_ruangan')
            ->leftJoin('jenis_asets', 'jenis_asets.id_jenis', '=', 'asets.id_jenis')
            ->leftJoin('kondisis', 'kondisis.id_kondisi', '=', 'asets.id_kondisi')
            ->where('asets.id_aset', $id)
            ->first();

        return view('fitur.detail_aset', [
            "data" => $dataAset,
            "url" => url('detail-aset/' . $req->id)
        ]);
    }


    public function qr_code(Request $req)
    {
        $id = Crypt::decrypt($req->id);

        $aset = Aset::findOrFail($id);

        return view('fitur.qr_code', [
            'aset' => $aset,
            'title' => 'QRcode',
            'data' => url('/detail_aset/' . $req->id)
        ]);
    }
}
