<?php

namespace App\Helpers;

class Paths {
    public static function combineIsRoute(string $user, string $route)
    {
        return $user.".".$route;
    }
}
