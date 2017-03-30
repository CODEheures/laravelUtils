<?php
namespace Codeheures\LaravelUtils\Traits\Locale;


use App\User;
use Illuminate\Support\Facades\App;

trait ManageLocale {

    public static function setAppLocale($locale) {

        $primaryLanguage = \Locale::getPrimaryLanguage($locale);

        if (in_array($primaryLanguage, config('codeheuresUtils.availableLocales'))) {
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