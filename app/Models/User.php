<?php

namespace App\Models;

use App\Helpers\RoleHelper;
use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRole, Notifiable, HasDatabaseNotifications;

    protected $fillable = ['name', 'email', 'password', 'branch_id', 'department_id', 'role', 'is_active', 'telegram_chat_id'];

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

    public function scopeSearch(Builder $query, ?string $search = '')
    {
        $query->when(!empty($search), function (Builder $query) use ($search) {
            $query->where(function ($query) use ($search) {
               $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        });
    }

    public function scopeByRole(Builder $query, ?int $roleId = null)
    {
        $query->when(!empty($roleId), function (Builder $query) use ($roleId) {
           $query->where('role', $roleId);
        });
    }
}
