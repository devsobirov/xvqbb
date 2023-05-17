<?php

namespace App\Models;

use App\Helpers\RoleHelper;
use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRole, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'branch_id', 'department_id', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function workplace(): null|Branch|Department
    {
        return match ($this->role) {
            RoleHelper::ADMIN,
            RoleHelper::HEAD_MANAGER => $this->department,
            RoleHelper::REGIONAL_MANAGER => $this->branch,
            default => null
        };
    }
}
