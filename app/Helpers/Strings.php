<?php

namespace App\Helpers;

class Strings {

    public static function stringReplace(string $str, string $search=" ", string $separator="-")
    {
        if(strlen($str) > 180) {
            $stringCut = substr($str, 0, -164);
            $ext = self::split_string($str, ".");
            $str = $stringCut . "." . $ext;
        }
        $mod = str_replace($search, $separator, strtolower($str));
        return date("YmdHis").$separator.$mod;
    }

    public static function split_string(string $str, string $separator="_")
    {
        $id = explode($separator, $str);
        return end($id);
    }
}
