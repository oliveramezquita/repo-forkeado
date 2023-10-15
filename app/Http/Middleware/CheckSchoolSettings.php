<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->route()->named('school.settings.create') || 
            $request->route()->named('school.settings.store') ||
            $request->route()->named('login') ||
            $request->route()->named('login.store') ||
            $request->route()->named('password.request') ||
            $request->route()->named('password.email') ||
            $request->route()->named('password.reset') ||
            $request->route()->named('password.store')) {
            return $next($request);
        }
    
        if (!\App\Models\Admin\SchoolSettings::exists()) {
            return redirect()->route('school.settings.create');
        }
    
        return $next($request);
    }
}
