<?php
namespace Codeheures\LaravelUtils\Traits\Locale;


use App\User;
use Illuminate\Support\Facades\App;

trait ManageLocale {

    public static function setAppLocale($locale) {
        $primaryLanguage = null;
        if(!is_null($locale) && $locale != ''){
            $primaryLanguage = \Locale::getPrimaryLanguage($locale);
        }

        if (!is_null($locale) && in_array($locale, config('codeheuresUtils.availableLocales'))) {
            App::setLocale($locale);
        } elseif (!is_null($primaryLanguage) && in_array($primaryLanguage, config('codeheuresUtils.availableLocales'))) {
            App::setLocale($primaryLanguage);
        } else {
            App::setLocale(config('app.fallback_locale'));
        }
    }

    public static function switchToUserLocale(User $user) {
        if(!is_null($user->locale)) {
            session(['runtimeLocale' => App::getLocale()]);
            self::setAppLocale(\Locale::getPrimaryLanguage($user->locale));
        }
    }

    public static function switchToRuntimeLocale() {
        if(!is_null(session('runtimeLocale'))){
            self::setAppLocale(session('runtimeLocale'));
            session()->forget('runtimeLocale');
        }
    }
}