<?php

namespace App\Helpers;

use App\Models\Berkas;
use App\Services\DigitalOceanSpaces;
use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Support\Facades\Http;

class Helper
{
    static $_status = array(
        'Pengajuan judul',
        'Pengajuan proposal',
        'Diterima dosen',
        'Review fakultas',
        'Revisi Fakultas',
        'Diterima Fakultas',
        'Review universitas',
        'Revisi Universitas',
        'Diterima Universitas'
    );

    static $_jenis = array(
        'R' => 'PKM Riset Eksakta',
        'RSH' => 'PKM Riset Sosial Humaniora',
        'K' => 'PKM Kewirausahaan',
        'PM' => 'PKM Pengabdian Kepada Masyarakat',
        'PI' => 'PKM Penerapan Iptek',
        'KC' => 'PKM Karsa Cipta',
        'GFK' => 'PKM Gagasan Futuristik Konstruktif',
        'GT' => 'PKM Gagasan Futuristik Tertulis',
        'VGK' => 'PKM Video Gagasan Konstruktif',
        'AI' => 'PKM Artikel Ilmiah'
    );

    static $_level = array(
        'M' => 'Mahasiswa',
        'D' => 'Dosen',
        'OP-F' => 'Operator Fakultas',
        'OP-U' => 'Operator Univesersitas',
        'RF' => 'Reviewer Universitas',
        'RU' => 'Reviewer Fakultas',
        'AD' => 'Admin',
    );

    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function status_pkm($loc)
    {
        return self::$_status[$loc];
    }

    public static function jenis_pkm($loc)
    {
        return self::$_jenis[$loc];
    }

    public static function level_user($loc)
    {
        return self::$_level[$loc];
    }

    static function _arr($array, $key, $default = NULL)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    static function _signature_verify($token, $data, $key)
    {
        return $token === hash_hmac('sha256', json_encode($data), $key);
    }

    public static function _camel_case($string, $delimiter = '-', $separator = ' ', $min_length = 2)
    {
        return implode(array_map(function ($x) use ($separator, $min_length) {
            return (strlen($x) <= $min_length ? strtoupper($x) : ucfirst($x)) . $separator;
        }, explode($delimiter, $string)));
    }

    public static function _breadcrumb($page = '')
    {
        $_tmp = '<ol class="breadcrumb">';
        $_tmp .= '<li><a href="' . "beranda" . '">Beranda</a></li>';
        if (strtolower($page) != "beranda") {
            if ($page == "404")
                $_tmp .= '<li>404</li>';
            else {
                // foreach (Routes::_gi()->_depths() as $_i => $_depth) {
                //     if ($_i == 0) continue;
                //     $_tmp .= '<li ' . (strtolower($page) == $_depth ? 'class="active"' : '') . '>' . self::_camel_case($_depth) . '</li>';
                // }

            }
        }
        $_tmp .= '</ol>';
        return $_tmp;
    }


    // public static function uploadBerkas($requestFile, $id) {
    //     $fileName = Strings::stringReplace($requestFile->getClientOriginalName(), " ", "_");

    //     $doSpaces = DigitalOceanSpaces::store($requestFile, $id);

    //     $berkasModel = Berkas::create([
    //         "name" => $fileName,
    //         "url" => DigitalOceanSpaces::url($doSpaces),
    //         "file_path" => $doSpaces,
    //         "extension" => $requestFile->getClientOriginalExtension()
    //     ]);

    //     return $berkasModel;
    // }

    public static function convertArrayStringJson($arrayStringJson) {
        $arrayStringJson = $arrayStringJson ?? array();

        $count = count($arrayStringJson);

        for ($i=0; $i < $count; $i++) {
            $arrayStringJson[$i] = json_decode($arrayStringJson[$i]);
        }

        return $arrayStringJson;
    }

    public static function filter($string)
    {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.

    }

    public static function get_nama($nim)
    {
        // API endpoint URL
        // dd($req);
        $url = 'https://sia.unram.ac.id/index.php/api2/Mahasiswas?NIM=' . $nim;

        // Send the request and get the response
        $response = Http::get($url);

        $result = [];

        // Check for errors
        if ($response->failed()) {
            echo "gagal";
            return $result;
        } else {
            // Convert JSON response to a PHP array
            $data = $response->json();
            foreach ($data as $array) {
              
                array_push($result, [
                    'nama' => $array['nama'],
                    'NIM' => $array['NIM'],
                ]);
            }
            return $result[0]['nama'] ?? $nim;

        }
    }

}
