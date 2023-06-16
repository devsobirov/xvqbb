<?php

namespace App\Models;

use App\Helpers\TaskStatusHelper;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory, HasStatus;

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'published_at' => 'datetime', // null = draft
        'finished_at' => 'datetime' // null = draft
    ];

    protected static string $statusHelper = TaskStatusHelper::class;

    const CLOSE_AFTER_DAYS_SINCE_EXPIRED = 3;

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class, 'task_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'filable');
    }

    public function scopeFinished(Builder $query)
    {
        $query->whereIn('status', [TaskStatusHelper::STATUS_CLOSED, TaskStatusHelper::STATUS_ARCHIVED]);
    }

    public function scopeSearch(Builder $query, $search = '')
    {
        $query->when(!empty($search), function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('code', strtoupper($search))
                    ->orWhere('title', 'like', "%$search%");
            });
        });
    }

    public function scopeByPeriod(Builder $query, ?string $from = null, ?string $to = null)
    {
        $query->when(!empty($from), function ($query) use ($from) {
            $query->whereDate('starts_at', '>=', $from);
        });

        $query->when(!empty($to), function ($query) use ($to) {
            $query->whereDate('starts_at', '<=', $to);
        });
    }

    public function scopeByDepartment(Builder $query, $departmentId = null)
    {
        $query->when(!empty($departmentId), function ($query) use ($departmentId) {
            $query->where('department_id',  $departmentId);
        });
    }

    public function scopeByExpirePeriod(Builder $query, ?string $from = null, ?string $to = null)
    {
        $query->when(!empty($from), function ($query) use ($from) {
            $query->whereDate('expires_at', '>=', $from);
        });

        $query->when(!empty($to), function ($query) use ($to) {
            $query->whereDate('expires_at', '<=', $to);
        });
    }

    public function scopeByStatus(Builder $query, $status = null)
    {
        $query->when(is_numeric($status), function ($query) use ($status) {
            $query->where('status',  $status);
        });
    }

    public function getUploadDirName(): string
    {
        $base = $this->created_at?->format('m-Y') ?? date('m-Y');
        return $base. DIRECTORY_SEPARATOR . $this->id.'_'.$this->code;
    }

    public function publish()
    {
        if (!$this->published()) {
            $this->published_at = now();
            $this->status = TaskStatusHelper::STATUS_ACTIVE;
            $this->save();
        }
    }

    public function pending(): bool
    {
        return  !$this->status || $this->status == TaskStatusHelper::STATUS_PENDING;
    }

    public function published(): bool
    {
        return $this->status == TaskStatusHelper::STATUS_ACTIVE;
    }

    public function expired(): bool
    {
        return $this->status == TaskStatusHelper::STATUS_EXPIRED || $this->expires_at?->lte(now());
    }

    public function finished(): bool
    {
        return  in_array($this->status, [TaskStatusHelper::STATUS_CLOSED, TaskStatusHelper::STATUS_ARCHIVED]);
    }

    public function expiredComparingTo($completed_at = null): bool
    {
        if ($completed_at) {
            return $this->expires_at?->lte($completed_at);
        }
        return false;
    }
}
