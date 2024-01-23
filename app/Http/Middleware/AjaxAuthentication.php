<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AjaxAuthentication
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        } elseif ($request->ajax() || $request->wantsJson()) {
            Log::info('JSON');
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        Log::info('HTML');
        return redirect()->guest('login');
    }
}
