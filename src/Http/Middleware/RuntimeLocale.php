<?php

namespace Codeheures\LaravelUtils\Http\Middleware;

use Closure;
use Codeheures\LaravelUtils\Traits\Geo\GeoUtils;
use Codeheures\LaravelUtils\Traits\Tools\Locale;

class RuntimeLocale
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

        //Set the best Locale config('runtime.locale')

        //reset session('runtime.locale') if http_accept_language change
        if(!session()->has('runtime.http_accept_language') || $request->server('HTTP_ACCEPT_LANGUAGE') != session('runtime.http_accept_language')){
            session()->forget('runtime.locale');
            session(['runtime.http_accept_language' => $request->server('HTTP_ACCEPT_LANGUAGE')]);
        }


        $httpAccept = \Locale::acceptFromHttp($request->server('HTTP_ACCEPT_LANGUAGE'));
        $requestLanguage = \Locale::getPrimaryLanguage($httpAccept);
        $requestRegion = \Locale::getRegion($httpAccept);

        try {

            $locale = null;

            //first set config('runtime.locale') by locale user attribute
            if (auth()->check() && !is_null(auth()->user()->locale)) {
                $locale = auth()->user()->locale;
                $locale = Locale::isValidLocale($locale);
            }

            //if fail try to set config('runtime.locale') by session value
            if (is_null($locale) && !is_null(session('runtime.locale'))) {
                $locale = session('runtime.locale');
                $locale = Locale::isValidLocale($locale);
            }

            //if fails try with request Region+locale
            if(is_null($locale) && $requestLanguage != '' && $requestRegion != '') {
                $locale = Locale::composeLocale($requestLanguage, $requestRegion);
                $locale = Locale::isValidLocale($locale);
            }

            //If fail, try with IP infos
            if (is_null($locale)) {
                try {
                    $country = GeoUtils::getCountryByIp(config('runtime.ip'));
                } catch (\Exception $e) {
                    $country = null;
                }

                if (!is_null($country) && $country != '' && $requestLanguage != '') {
                    $locale = Locale::composeLocale($requestLanguage, $country);
                    $locale = Locale::isValidLocale($locale);
                }
            }

            //If fail try to get First locale by language
            if(is_null($locale) && $requestLanguage != '') {
                $locale = Locale::getFirstLocaleByLanguageCode($requestLanguage);
                $locale = Locale::isValidLocale($locale);
            }

            //If fails try with env('DEFAULT_LOCALE') or last_fall_back
            if (is_null($locale)) {
               $locale = Locale::getDefaultLocale();
            }

            config(['runtime.locale' => $locale]);


        } catch(\Exception $e) {
            config(['runtime.locale' => Locale::$last_fallback_locale]);
        }

        session(['runtime.locale' => config('runtime.locale')]);


        return $next($request);

    }
}
