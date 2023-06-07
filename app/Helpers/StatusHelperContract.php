<?php


namespace App\Helpers;


interface StatusHelperContract
{
    public static function init(): self;
    public static function getStatusName(?int $status): string;
    public static function getTimestampName(?int $status): ?string;
    public static function statusExists(?int $status): bool;
    public static function getStatusColor($status): string;
    public static function published(?int $status): bool;
    public static function editable(?int $status): bool;
}
