<?php

namespace App\Helpers;

use App\Models\Akademik;

class AkademikHelper
{
    public static function updateOrCreateAkademik($_usso, $_info, $_login, $_level)
    {

        return Akademik::updateOrCreate(
            [
                'akademik_username' => Helper::_arr($_login, 'username')
            ],
            [
                "akademik_nama" => Helper::_arr($_info, 'operator_nama'),
                "akademik_hp" => Helper::_arr($_info, 'operator_hp'),
                "prodi_id" => Helper::_arr($_info, 'kode'),
                "prodi_id_national" => Helper::_arr($_info, 'kode_nasional'),
                "kode_fakultas" => Helper::_arr($_info, 'kode_fakultas'),
                "kode_prodi_unram" => Helper::_arr($_info, 'kode_prodi_unram'),
                "akademik_status" => Helper::_arr($_info, 'status'),
                "akademik_nama_fakultas" => Helper::_arr($_info, 'nama_fakultas'),

                "akademik_signature" => Helper::_arr($_usso, 'signature', time()),

                "kode_akses" => Helper::_arr($_level, 'kode_akses'),
                "kode_view" => Helper::_arr($_level, 'kode_view'),
                "kode_object" => Helper::_arr($_level, 'kode_object'),
            ]
        );
    }
}
