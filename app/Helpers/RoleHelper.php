<?php

namespace App\Helpers;


class RoleHelper
{
    const ADMIN = 1;
    const HEAD_MANAGER = 5;
    const REGIONAL_MANAGER = 10;

    const ROLES  = [
        self::ADMIN => 'Administrator',
        self::HEAD_MANAGER => "Bo'lim mudiri",
        self::REGIONAL_MANAGER => "Filial xodimi"
    ];

    public static function getRole($role = null): string
    {
        if (self::roleExists($role)) {
            return self::ROLES[$role];
        }
        return "-";
    }

    public static function getRoles(): array
    {
        return self::ROLES;
    }

    public static function roleExists($role): bool
    {
        return array_key_exists($role, self::ROLES);
    }
}
