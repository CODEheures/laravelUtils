<?php

namespace Codeheures\LaravelUtils\Http\Middleware;

use Closure;
use Codeheures\LaravelUtils\Traits\Geo\GeoUtils;
use Codeheures\LaravelUtils\Traits\Tools\Locale;

class RuntimeLocale
{

    CONST LAST_FALLBACK_LOCALE = 'en_US';

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
                $this->setValidLocale($locale);
            }

            //if fail try to set config('runtime.locale') by session value
            if (is_null($locale) && !is_null(session('runtime.locale'))) {
                $locale = session('runtime.locale');
                $this->setValidLocale($locale);
            }

            //if fails try with request Region+locale
            if(is_null($locale) && $requestLanguage != '' && $requestRegion != '') {
                $locale = Locale::composeLocale($requestLanguage, $requestRegion);
                $this->setValidLocale($locale);
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
                    $this->setValidLocale($locale);
                }
            }

            //If fail try to get First locale by language
            if(is_null($locale) && $requestLanguage != '') {
                $locale = Locale::getFirstLocaleByLanguageCode($requestLanguage);
                $this->setValidLocale($locale);
            }

            //If fails try with env('DEFAULT_LOCALE')
            if (is_null($locale) && !is_null(env('DEFAULT_LOCALE'))) {
                $locale = env('DEFAULT_LOCALE');
                $this->setValidLocale($locale);
            }

            //Finally use last fallback
            if (is_null($locale)) {
                $locale = self::LAST_FALLBACK_LOCALE;
            }

            config(['runtime.locale' => $locale]);


        } catch(\Exception $e) {
            config(['runtime.locale' => self::LAST_FALLBACK_LOCALE]);
        }

        session(['runtime.locale' => config('runtime.locale')]);


        return $next($request);

    }

    private function setValidLocale($locale) {
        if(!is_null($locale) && !Locale::existLocale($locale)){
            $locale = null;
        }
        return $locale;
    }
}
