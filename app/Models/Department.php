<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public static function getForList(): Collection
    {
        return self::select('id', 'name')->get();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
