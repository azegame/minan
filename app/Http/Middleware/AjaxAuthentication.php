<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Vote;
use App\Models\Option;

class AjaxAuthentication
{
    public function handle($request, Closure $next)
    {
        $optionId = $request->route('id');
        if (Auth::check()) {
            return $next($request);
        } elseif ($request->ajax() || $request->wantsJson()) {
            Log::info('JSON');
            $option = Option::find($optionId);
            $vote_count = $option->vote_count;
            return response()->json(['error' => '認証してね.', 'newVoteCount' => $vote_count], 401);
        }
        Log::info('HTML');
        return redirect()->guest('login');
    }
}
