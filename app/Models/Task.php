<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'starts_at',
        'expires_at',
        'published_at' // null = draft
    ];

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
}
