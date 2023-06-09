<?php

namespace App\Helpers;

use App\Models\Mahasiswa;

class MahasiswaHelper
{
    const _status_aktif = 1;
    const _status_tidak_aktif = 0;

    static $_UKT_check = array(
        self::_status_aktif => true,
        self::_status_tidak_aktif => false,
    );

    static $_kuliah = array(
        'A' => 'Aktif',
        'P' => 'Pindah',
        'C' => 'Cuti',
        'D' => 'DO',
        'B' => 'Bayar SPP Tapi Tidak KRS',
        'M' => 'Tidak Bayar SPP',
        'N' => 'Non Aktif',
        'G' => 'Double Degree',
        'L' => 'Lulus'
    );

    public static function getStatusKuliah($int_status) {
        return self::$_kuliah[$int_status];
    }

    public static function getStatusUKT($int_status) {
        return self::$_UKT_check[$int_status];
    }

    public function _get_sia($nim)
    {
        return Helper::_fetch(env('URI_SIA') . '/index.php/api2/Mahasiswa?nim=' . $nim);
    }

    /**
     * Fetch terbaru data mahasiswa dari API SIA
     *
     * @param [type] $nim
     * @return void
     */
    public static function latestSIA($nim)
    {
        $fetchData = MahasiswaHelper::_get_sia($nim);

        return $fetchData;
    }

    public static function updateOrCreateMahasiswa($_usso, $_info, $_login, $_level)
    {
        $nim = Helper::_arr($_info, 'NIM');

        $newDataMahasiswa = self::latestSIA($nim);

        return Mahasiswa::updateOrCreate(
            [
                'mahasiswa_nim' => $nim
            ],
            [
                "mahasiswa_nama" => Helper::_arr($_info, 'nama'),
                "mahasiswa_nomor_hp" => Helper::_arr($_info, 'no_hp'),
                "prodi_id" => Helper::_arr($_info, 'kode_prodi'),
                "nama_prodi" => Helper::_arr($_info, 'nama_prodi'),
                "nama_fakultas" => Helper::_arr($_info, 'nama_fakultas'),
                "mahasiswa_email" => Helper::_arr($_info, 'email'),
                "mahasiswa_status_kuliah" => Helper::_arr($_info, 'status_kuliah'),
                "status_bayar" => Helper::_arr($_info, 'status_bayar'),
                "mahasiswa_foto" => Helper::_arr($_info, 'foto'),
                "mahasiswa_tempat_lahir" => $newDataMahasiswa["tempat_lahir"],
                "mahasiswa_tanggal_lahir" => $newDataMahasiswa["tgl_lahir"],

                "kode_fakultas" => Helper::_arr($_info, 'kode_fakultas'),
                "kode_akses" => Helper::_arr($_level, 'kode_akses'),
                "kode_view" => Helper::_arr($_level, 'kode_view'),

                "mahasiswa_signature" => Helper::_arr($_usso, 'signature', time()),
            ]
        );
    }
}
