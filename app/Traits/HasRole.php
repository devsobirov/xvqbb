<?php

namespace App\Traits;

use Role;

trait HasRole
{
    public function isAdmin(): bool
    {
        return intval($this->role) === Role::ADMIN;
    }

    public function isManager(): bool
    {
        return intval($this->role) === Role::HEAD_MANAGER || $this->isAdmin();
    }

    public function isBranchManager(): bool
    {
        return intval($this->role) === Role::REGIONAL_MANAGER;
    }

    public function hasRole($role): bool
    {
        return match (intval($role)) {
            Role::ADMIN => $this->isAdmin(),
            Role::HEAD_MANAGER => $this->isManager(),
            Role::REGIONAL_MANAGER => $this->isBranchManager(),
            default => false
        };
    }
}
