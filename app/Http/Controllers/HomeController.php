<?php

namespace App\Http\Controllers;

use Auth;
use Role;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return match ($user->role) {
            Role::ADMIN, Role::HEAD_MANAGER => redirect()->route('head.home'),
            Role::REGIONAL_MANAGER => redirect()->route('branch.home'),
            default => abort(403)
        };
    }
}
