<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Location
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
        $local = ($request->hasHeader('locale')) ? $request->header('locale') : config('app.locale');
        // set laravel localization
        app()->setLocale($local);
        return $next($request);
    }
}
