<?php


namespace App\Helpers;


class TaskStatusHelper implements StatusHelperContract
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_EXPIRED = 3;
    const STATUS_CLOSED = 4;
    const STATUS_ARCHIVED = 5;

    const STATUSES = [
        self::STATUS_PENDING => 'Tasdiqlanmagan',
        self::STATUS_ACTIVE => 'Aktiv',
        self::STATUS_EXPIRED => 'Eskirgan',
        self::STATUS_CLOSED => 'Tugatilgan',
        self::STATUS_ARCHIVED => 'Arxivga olingan',
    ];

    public static function init(): StatusHelperContract
    {
        return app(self::class);
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
        return match ($status) {
            self::STATUS_ACTIVE => 'published_at',
            self::STATUS_EXPIRED => 'expires_at',
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
            self::STATUS_ACTIVE => 'yellow',
            self::STATUS_EXPIRED => 'danger',
            self::STATUS_CLOSED => 'success',
            default => 'secondary'
        };
    }

    public static function published($status): bool
    {
        return $status == self::STATUS_ACTIVE;
    }

    public static function editable(?int $status): bool
    {
        return in_array($status, [self::STATUS_ACTIVE, self::STATUS_EXPIRED]);
    }
}
