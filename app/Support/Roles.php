<?php

namespace App\Support;

class Roles
{
    public const ADMIN = 'admin';
    public const MASUL_XODIM = 'masul_xodim';
    public const IZLANUVCHI = 'izlanuvchi';

    public static function all(): array
    {
        return [self::ADMIN, self::MASUL_XODIM, self::IZLANUVCHI];
    }

    public static function labels(): array
    {
        return [
            self::ADMIN => 'Admin',
            self::MASUL_XODIM => "Mas'ul xodim",
            self::IZLANUVCHI => 'Izlanuvchi',
        ];
    }
}
