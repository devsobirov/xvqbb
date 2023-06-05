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

    const TIMESTAMPS = [
        self::PENDING => null,
        self::PUBLISHED => null,
        self::PROCESSED => 'processed_at',
        self::COMPLETED => 'completed_at',
        self::REJECTED => 'rejected_at',
        self::APPROVED => 'approved_at'
    ];

    public static function getStatusName(?int $status): string
    {
        if (self::statusExists($status)) {
            return self::STATUSES[$status];
        }

        return "No'malum";
    }

    public static function getTimestampName(?int $status): ?string
    {
        if (self::statusExists($status) && !empty(self::TIMESTAMPS[$status])) {
            return self::TIMESTAMPS[$status];
        }
        return null;
    }

    public static function statusExists(?int $status): bool
    {
        return array_key_exists($status, self::STATUSES);
    }

    public static function getStatusColor($status): string
    {
        return match ($status) {
          self::PROCESSED => 'yellow',
          self::COMPLETED => 'primary',
          self::REJECTED => 'danger',
          self::APPROVED => 'success',
          default => 'secondary'
        };
    }
}
