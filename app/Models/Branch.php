<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestapms = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class, 'branch_id');
    }

    public static function getForList(): Collection
    {
        return self::select('id', 'name')->get();
    }
}
