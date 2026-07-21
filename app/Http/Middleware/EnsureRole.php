<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = (int) $request->user()->role;

        $allowedRoleIds = [];
        foreach ($roles as $role) {
            $roleLower = strtolower(trim($role));
            if ($roleLower === 'admin' || $roleLower === '1') {
                $allowedRoleIds[] = User::ROLE_ADMIN;
            } elseif ($roleLower === 'pembimbing' || $roleLower === '2') {
                $allowedRoleIds[] = User::ROLE_PEMBIMBING;
            } elseif ($roleLower === 'peserta' || $roleLower === '3') {
                $allowedRoleIds[] = User::ROLE_PESERTA;
            }
        }

        if (! in_array($userRole, $allowedRoleIds, true)) {
            abort(403, 'Akses tidak diizinkan. Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
