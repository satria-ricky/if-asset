<?php

namespace App\Helpers;

use App\Models\Operator;
use App\Models\Prodi;

class OperatorHelper
{
    public static function getProdiName($prodiId)
    {
        $find = Prodi::where("prodi_id", $prodiId)->get()->first();

        return $find->prodi_nama ?? "";
    }

    public static function updateOrCreateOperator($_usso, $_info, $_login, $_level)
    {

        return Operator::updateOrCreate(
            [
                'operator_username' => Helper::_arr($_login, 'username')
            ],
            [
                "operator_nama" => Helper::_arr($_info, 'operator_nama'),
                "operator_hp" => Helper::_arr($_info, 'operator_hp'),
                "prodi_id" => Helper::_arr($_info, 'kode'),
                "prodi_id_national" => Helper::_arr($_info, 'kode_nasional'),
                "kode_fakultas" => Helper::_arr($_info, 'kode_fakultas'),
                "kode_prodi_unram" => Helper::_arr($_info, 'kode_prodi_unram'),
                "operator_status" => Helper::_arr($_info, 'status'),
                "operator_nama_fakultas" => Helper::_arr($_info, 'nama_fakultas'),

                "operator_signature" => Helper::_arr($_usso, 'signature', time()),

                "kode_akses" => Helper::_arr($_level, 'kode_akses'),
                "kode_view" => Helper::_arr($_level, 'kode_view'),
                "kode_object" => Helper::_arr($_level, 'kode_object'),
            ]
        );
    }
}
