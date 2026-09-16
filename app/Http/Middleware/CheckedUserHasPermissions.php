<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Route;
class CheckedUserHasPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$model): Response
    {
        $action = explode('@', Route::current()->getActionName())[1];

//        if (auth()->user()->hasRole('Super Admin')){
//            return $next($request);
//        }

        if (count(auth()->user()->getAllPermissions()) == 0){
            abort(403);
        }

        if (auth()->user()->hasAllPermissions($action . ' ' . $model)) {
            return $next($request);
        } else {
            if ($request->ajax()){
                abort(403);
            }
            abort(403);
        }
    }

}
