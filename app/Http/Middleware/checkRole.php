<?php

namespace App\Http\Middleware;

use Closure;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if ($request->user()->role == $role) {
            return $next($request);
        } else {
            request()->session()->flash('error', 'You do not have any permission to access this page');
            return redirect()->back();
        }
    }
}
