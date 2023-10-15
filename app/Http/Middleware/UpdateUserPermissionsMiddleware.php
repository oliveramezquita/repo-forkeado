<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class UpdateUserPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('userPermissions')) {

            $user = $request->user();
            $permissions = [];
    
            if ($user) {
                $roles = $user->getRoleNames();
    
                foreach ($roles as $roleName) {
                    $role = Role::where('name', $roleName)->first();
                    if ($role) {
                        $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
                    }
                }
    
                Inertia::share(['userPermissions' => $permissions]);
            }
        }

        return $next($request);
    }
}
