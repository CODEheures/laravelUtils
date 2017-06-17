<?php

namespace Codeheures\LaravelUtils\Traits\Tools;


trait Locale
{

    public static $last_fallback_locale = 'en';

    /**
     * Return Array of Available Locales On server
     *
     * @return array
     */
    public static function listLocales($restrictByAppLanguages=false) {
        $locales = \ResourceBundle::getLocales('');

        $listLocales = [];
        foreach ($locales as $locale) {
            $isAvailableToAddInArray = true;
            if ($restrictByAppLanguages===true) {
                $primaryLanguage = \Locale::getPrimaryLanguage($locale);
                if (is_null($primaryLanguage) || !in_array($primaryLanguage, config('codeheuresUtils.availableLocales'))) {
                    $isAvailableToAddInArray=false;
                }
            }

            if($isAvailableToAddInArray) {
                $listLocales[$locale] = [
                    'code' => $locale,
                    'name' => \Locale::getDisplayName($locale),
                    'region' => strtolower(\Locale::getDisplayRegion($locale))
                ];
            }
        }

        return $listLocales;
    }

    /**
     * Test if param locale exist on server list (Example: $locale: "fr_FR", "fr")
     *
     * @param $locale
     * @return bool
     */
    public static function existLocale($locale) {
        $listLocales = self::listLocales();
        foreach ($listLocales as $item) {
            if($item['code'] == $locale){
                return true;
            }
        }
        return false;
    }

    /**
     * Return the First possible locale for a Country ISO Code (Example $countryCode: "ca" => "en_CA")
     *
     * @param $countryCode
     * @return null
     */
    public static function getFirstLocaleByCountryCode($countryCode){
        foreach (self::listLocales() as $locale){
            if(strpos($locale['code'], '_'. strtoupper($countryCode))){
                return $locale['code'];
            }
        }
        return null;
    }

    /**
     * Return the First possible locale for a Language Code (Example $lang: "fr" => "fr")
     *
     * @param $countryCode
     * @return null
     */
    public static function getFirstLocaleByLanguageCode($language){
        foreach (self::listLocales() as $locale){
            if(strpos($locale['code'], $language)===0){
                return $locale['code'];
            }
        }
        return null;
    }

    /**
     *
     * Return a compose locale if exist on server list locale
     *
     * @param $language
     * @param $region
     * @return null|string
     */
    public static function composeLocale($language, $region){
        $locale = \Locale::composeLocale( [
            'language' => $language,
            'region' => $region
        ] );
        if(self::existLocale($locale)){
            return $locale;
        } else {
            return null;
        }
    }

    /**
     *
     * return a default locale within env('DEFAULT_LOCALE') or static last_fallback_locale
     *
     * @return string
     */
    public static function getDefaultLocale() {
        $locale  = null;
        //If fails try with env('DEFAULT_LOCALE')
        if (!is_null(env('DEFAULT_LOCALE'))) {
            $locale = env('DEFAULT_LOCALE');
            $locale = self::isValidLocale($locale);
        }

        //Finally use last fallback
        if (is_null($locale)) {
            $locale = self::$last_fallback_locale;
        }

        return $locale;
    }

    /**
     *
     * Test if a locale is a valid locale and return locale or null
     *
     * @param $locale
     * @return null|string
     *
     */
    public static function isValidLocale($locale) {
        if(!is_null($locale) && !self::existLocale($locale)){
            $locale = null;
        }
        return $locale;
    }
}