<?php

namespace App\Models;

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
}
