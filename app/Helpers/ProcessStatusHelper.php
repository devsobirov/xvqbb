<?php

namespace App\Helpers;


class ProcessStatusHelper
{
    const PENDING = 0;
    const PUBLISHED = 1;
    const PROCESSED = 2;
    const COMPLETED = 3;
    const REJECTED = 4;
    const APPROVED = 5;

    const STATUSES = [
        self::PENDING => 'Tasdiqlanmagan',
        self::PUBLISHED => 'Tanishilmagan',
        self::PROCESSED => 'Jarayonda',
        self::COMPLETED => 'Bajarilgan',
        self::REJECTED => 'Bekor qilingan',
        self::APPROVED => 'Qabul qilingan'
    ];

    public static function getStatusName(?int $status): string
    {
        if (self::statusExists($status)) {
            return self::STATUSES[$status];
        }

        return "No'malum";
    }

    public static function statusExists(?int $status): bool
    {
        return array_key_exists($status, self::STATUSES);
    }
}
