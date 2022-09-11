<?php

namespace App\Http\Middleware\admin;

use Closure;
use Illuminate\Http\Request;

class Aministration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->isAdmin()){
            return $next($request);
        }
        abort(403);
    }
}
