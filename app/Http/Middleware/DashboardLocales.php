<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DashboardLocales
{
    public function handle(Request $request, Closure $next)
    {
        // هنا منطق اختيار اللغة
        // مثلاً من السيشن أو من إعدادات المستخدم

        $locale = session('dashboard_locale', config('app.locale'));
        app()->setLocale($locale);

        return $next($request);
    }
}
