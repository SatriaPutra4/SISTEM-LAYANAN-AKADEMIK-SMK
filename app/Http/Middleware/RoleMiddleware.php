<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        \Log::info('Role Check Debug:', [
            'user_exists' => !!$user,
            'user_id' => $user?->id,
            'expected_role' => $role,
            'actual_role' => $user?->role,
            'match' => $user && $user->role === $role
        ]);

        if (!$user || $user->role !== $role) {
             return new Response('Unauthorized access. Expected: ' . $role . ', Actual: ' . ($user?->role ?? 'null'), 403);
        }

        return $next($request);
    }
}
