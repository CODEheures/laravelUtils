<?php

namespace Codeheures\LaravelUtils\Traits\Tools;

use Money\Currencies\ISOCurrencies;
use Money\Currency;

trait Currencies
{

    public static $last_fallback_currency = 'EUR';

    /**
     *
     * Return true if currency exist (example $currency: "EUR", "USD")
     *
     * @param $currency
     * @return bool
     */
    public static function isAvailableCurrency($currency) {
        $currencies = new ISOCurrencies();
        if (!is_null($currency) && $currency != '' && $currencies->contains(new Currency($currency))) {
            return true;
        }
        return false;
    }

    /**
     *
     * Return the subunit decimal of currency (example $currency: "EUR" => subUnit=2)
     *
     * @param $currency
     * @return int
     */
    public static function getSubUnit($currency) {
        if(self::isAvailableCurrency($currency)){
            $currencies = new ISOCurrencies();
            return $currencies->subunitFor(new Currency($currency));
        }
        return 0;
    }

    /**
     *
     * Return the List of code & symbol currency according to locale (example locale: "fr")
     *
     * @return array
     */
    public static function listCurrencies($locale)  {
        $currencies = new ISOCurrencies();

        $listCodeCurrencies=[];
        foreach ($currencies as $currency) {

            $region = $locale."@currency=$currency";
            $formatter = new \NumberFormatter($region, \NumberFormatter::CURRENCY);
            $symbol = $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);

            if($symbol != '') {
                $listCodeCurrencies[$currency->getCode()] = [
                    'code' => $currency->getCode(),
                    'symbol' => $symbol];
            }
        }
        return $listCodeCurrencies;
    }

    /**
     *
     * Get the appropriate currency symbol according to locale (example $currencycode:"CAD" $locale:"fr" => $CA)
     *
     * @param $currencyCode
     * @param $locale
     * @return null
     */
    public static function getSymbolByCurrencyCode($currencyCode, $locale) {
        $listCurrencies = self::listCurrencies($locale);
        foreach ($listCurrencies as $currency){
            if($currency['code'] == $currencyCode){
                return $currency['symbol'];
            }
        }
        return null;
    }

    /**
     *
     * Return a default money according to locale (example $locale: "fr_CA" => "CAD")
     *
     * @param $locale
     * @return mixed|string
     */
    public static function getDefaultMoneyByComposeLocale($locale, $default) {
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $currency =  $numberFormatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE);
        if(self::isAvailableCurrency($currency)){
            return $currency;
        } else {
            return $default;
        }
    }

    /**
     *
     * return a default currency within env('DEFAULT_CURRENCY') or static $last_fallback_currency
     *
     * @return null
     */
    public static function getDefaultCurrency() {
        $currency  = null;

        if (!is_null(env('DEFAULT_CURRENCY'))) {
            $currency = env('DEFAULT_CURRENCY');
        }

        //Finally use last fallback
        if (is_null($currency) || !self::isAvailableCurrency($currency)) {
            $currency = self::$last_fallback_currency;
        }

        return $currency;
    }
}