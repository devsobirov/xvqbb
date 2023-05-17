<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = ''): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        abort_if(!$user->is_active || !$this->hasAnyOrSpecificRole($user, $role), 403, 'Permission denied');
        return $next($request);
    }

    private function hasAnyOrSpecificRole($user, $role): bool
    {
        return $role
            ? $user->hasRole($role)
            : $user->role;
    }
}
