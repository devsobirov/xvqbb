<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function filable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class, 'user_id');
    }

    public function getReadableFileName(): string
    {
        $code = $this->filable->code ?? 'taskCode';
        $base = $this->user?->workplace()?->name ?? 'workplace';

        return $code.'-'.$base.'.'. $this->extension;
    }
}
