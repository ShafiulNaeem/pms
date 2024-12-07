<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('api')->check()) {
            if (auth()->guard('api')->user()->role !== 'user') {
                return sendError('You are not authorised to access.', [], Response::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
