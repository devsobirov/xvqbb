<?php

namespace App\Helpers;


class ProcessStatusHelper implements StatusHelperContract
{
    const PENDING = 0;
    const PUBLISHED = 1;
    const UN_EXECUTED = 2;
    const PROCESSED = 3;
    const REJECTED = 4;
    const COMPLETED = 5;
    const APPROVED = 6;

    const STATUSES = [
        self::PENDING => 'Tasdiqlanmagan',
        self::PUBLISHED => 'Tanishilmagan',
        self::UN_EXECUTED => 'Bajarilmagan',
        self::PROCESSED => 'Bajarilmoqda',
        self::REJECTED => 'Qayta nazoratga olingan',
        self::COMPLETED => 'Bajarilgan',
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

    public static function init(): StatusHelperContract
    {
        return app(self::class);
    }

    public static function getVisibleStatuses(): array
    {
        $statuses = self::STATUSES;
        unset($statuses[self::PENDING]);
        unset($statuses[self::UN_EXECUTED]);
        return $statuses;
    }

    public static function getStatusName(?int $status): string
    {
        if (self::statusExists($status)) {
            return self::STATUSES[$status];
        }

        return "No'malum";
    }

    public static function getTimestampName(?int $status): ?string
    {
        return match($status) {
            self::PROCESSED => 'processed_at',
            self::COMPLETED => 'completed_at',
            self::REJECTED => 'rejected_at',
            self::APPROVED => 'approved_at',
            default => null
        };
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
          self::REJECTED , self::UN_EXECUTED => 'danger',
          self::APPROVED => 'success',
          default => 'secondary'
        };
    }

    public static function published($status): bool
    {
        return $status == self::PUBLISHED;
    }

    public static function editable(?int $status): bool
    {
        return in_array($status, [self::PUBLISHED, self::PROCESSED, self::REJECTED]);
    }
}
