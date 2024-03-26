<?php

namespace App\Http\Middlware;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role === 'CLIENT') {
            return redirect()->route('projects.client');
        }

        return $next($request);
    }
}
