<?php

namespace App\Helpers;

class YudisiumHelper
{
    const _status_menunggu = 0;
    const _status_diajukan = 1;
    const _status_ditolak = 2;
    const _status_diproses = 3;
    const _status_selesai = 4;
    const _status_diambil = 5;

    static $_status_color_map = array(
        self::_status_menunggu => 'default',
        self::_status_diajukan => 'warning',
        self::_status_ditolak => 'danger',
        self::_status_diproses => 'info',
        self::_status_selesai => 'success',
        self::_status_diambil => 'success',
    );

    static $_status = array(
        self::_status_menunggu => 'Belum diajukan',
        self::_status_diajukan => 'Diajukan',
        self::_status_ditolak => 'Ditolak',
        self::_status_diproses => 'Diproses',
        self::_status_selesai => 'Selesai',
        self::_status_diambil => 'Diambil',
    );

    public static function getStatus($int_status) {
        return self::$_status[$int_status];
    }

    public static function getStatusColorMap($int_status) {
        return self::$_status_color_map[$int_status];
    }

    public static function canSubmit($status){
        if ($status == self::_status_menunggu) {
            return true;
        }

        if ($status == self::_status_ditolak) {
            return true;
        }

        return false;
    }
}
