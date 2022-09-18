<?php

namespace App\Http\Middleware\admin;

use Closure;
use Exception;
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
        if(auth()->check() && auth()->user()->hasValidRole(auth()->user()->role)){
            return $next($request);
        }
        throw new Exception('The role is not found');
    }
}
