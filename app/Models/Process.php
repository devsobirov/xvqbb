<?php

namespace App\Models;

use App\Helpers\ProcessStatusHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Process extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'filable');
    }

    public function publish(): bool
    {
        if (!$this->status || $this->status == ProcessStatusHelper::PENDING) {
            $this->status = ProcessStatusHelper::PUBLISHED;
            return $this->save();
        }
        return false;
    }

    public function getStatusName(): string
    {
        return ProcessStatusHelper::getStatusName($this->status);
    }

    public function getStatusColor($status = null): string
    {
        return ProcessStatusHelper::getStatusColor($status ? $status : $this->status);
    }

    public function lastStatusChanged(): ?\Illuminate\Support\Carbon
    {
        $tmp = ProcessStatusHelper::getTimestampName($this->status);
        if ($tmp) {
            return $this->$tmp;
        }
        return null;
    }

    public function updatedAt($status = null): ?\Illuminate\Support\Carbon
    {
        $tmp = ProcessStatusHelper::getTimestampName($status ? $status : $this->status);
        if ($tmp) {
            return $this->$tmp;
        }
        return null;
    }

    public function getUploadDirName(): string
    {
        $base = $this->task->getUploadDirName();
        return $base . DIRECTORY_SEPARATOR . $this->branch->prefix;
    }
}
