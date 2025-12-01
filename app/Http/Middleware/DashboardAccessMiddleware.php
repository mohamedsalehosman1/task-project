<?php

namespace App\Http\Middleware;

use Closure;

class DashboardAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->canAccessDashboard()) {
            abort(403);
        }

        if (auth()->user()->isWasher() && !auth()->user()->washer->HasPackageValid) {
            return redirect()->route('dashboard.packages.subscription');
        }

        return $next($request);
    }
}
