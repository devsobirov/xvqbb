<?php


namespace App\Traits;

use App\Helpers\StatusHelperContract;

trait HasStatus
{
    public string $statusColor = '';
    public string $statusName = '';
    public ?bool $isPublished = null;

    public function helper(): StatusHelperContract
    {
        return self::$statusHelper::init();
    }

    public function getStatusName(): string
    {
        if (!$this->statusName) {
            $this->statusName = $this->helper()::getStatusName($this->status);
        }
        return $this->statusName;
    }

    public function getStatusColor($status = null): string
    {
        if (!$this->statusColor || $status) {
            $this->statusColor = $this->helper()::getStatusColor($status ? $status : $this->status);
        }
        return $this->statusColor;
    }

    public function lastStatusChanged(): ?\Illuminate\Support\Carbon
    {
        $tmp = $this->helper()::getTimestampName($this->status);
        if ($tmp) {
            return $this->$tmp;
        }
        return null;
    }

    public function updatedAt($status = null): ?\Illuminate\Support\Carbon
    {
        $tmp = $this->helper()::getTimestampName($status ? $status : $this->status);
        if ($tmp) {
            return $this->$tmp;
        }
        return null;
    }

    public function published(): bool
    {
        if (!is_bool($this->isPublished)) {
            $this->isPublished = $this->helper()::published($this->status);
        }
        return $this->isPublished;
    }

    public function editable(): bool
    {
        return $this->helper()::editable($this->status);
    }
}
