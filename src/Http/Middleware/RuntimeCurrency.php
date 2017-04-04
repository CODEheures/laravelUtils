<?php

namespace Codeheures\LaravelUtils\Http\Middleware;

use Closure;
use Codeheures\LaravelUtils\Traits\Tools\Currencies;
use Codeheures\LaravelUtils\Traits\Tools\Locale;

class RuntimeCurrency
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

        //config('runtime.currency')
        try {
            $currency = null;
            if(auth()->check() && !is_null(auth()->user()->currency)) {
                $currency = auth()->user()->currency;
            } else {
                $currency = Currencies::getDefaultMoneyByComposeLocale(config('runtime.locale'), Locale::getDefaultLocale());
            }

            if(!Currencies::isAvailableCurrency($currency)) {
                $currency = Currencies::getDefaultCurrency();
            }

            config(['runtime.currency' => $currency]);

        } catch (\Exception $e) {
            config(['runtime.currency' => Currencies::$last_fallback_currency]);
        }
        return $next($request);

    }
}
