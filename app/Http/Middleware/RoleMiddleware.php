<?php

namespace App\Http\Middleware;

class RoleMiddleware {
    public function handle($request, \Closure $next) {
        if (!$request->auth->hasRole("admin")) {
            return response()->json(['message' => 'UNAUTHORIZED'], 403);
        }
        return $next($request);
    }
}