<?php

namespace Codeheures\LaravelUtils\Http\Middleware;

use Closure;
use Codeheures\LaravelUtils\Traits\Tools\Ip;

class RuntimeIp
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

        //config('runtime.ip')
        config(['runtime.ip' => Ip::getNonPrivateIpByRequest($request)]);

        return $next($request);

    }
}
