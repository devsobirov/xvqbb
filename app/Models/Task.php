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

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'published_at' => 'datetime' // null = draft
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

    public function getUploadDirName(): string
    {
        return 'task_' . $this->id;
    }

    public function publish()
    {
        if (!$this->published()) {
            $this->published_at = now();
            $this->save();
        }
    }

    public function published(): bool
    {
        return !!$this->published_at;
    }
}
