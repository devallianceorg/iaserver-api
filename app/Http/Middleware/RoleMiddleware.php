<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Se usaría de la siguiente manera:
     * 
     * Route::group(['middleware' => 'role:project-manager'], function() {
     *   Route::get('/dashboard', function() {
     *     return 'Welcome Project Manager';
     *   });
     * });
     * 
     * @param $request
     * @param Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!auth()->user()->hasRole($role)) {
            abort(404);
        }
        if($permission !== null && !auth()->user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
