<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware: checking authentication and admin role.');

        if (!Auth::check()) {
            Log::info('AdminMiddleware: user not authenticated.');
            return redirect()->route('admin.login')->withErrors(['message' => 'You must be logged in']);
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            Log::info('AdminMiddleware: user is not an admin.');
            abort(403, 'Unauthorized');
        }

        Log::info('AdminMiddleware: user is authenticated and is an admin.');

        return $next($request);
    }
}
