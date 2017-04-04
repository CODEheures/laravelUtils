<?php

namespace App\Http\Middleware;

use Closure;
use Codeheures\LaravelUtils\Traits\Locale\ManageLocale;

class SetLocaleByRuntime
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

        ManageLocale::setAppLocale(config('runtime.locale'));

        return $next($request);
    }
}