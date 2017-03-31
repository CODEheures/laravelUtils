<?php

namespace Codeheures\LaravelUtils\Traits\Tools;

use Money\Currencies\ISOCurrencies;
use Money\Currency;

trait Currencies
{
    /**
     *
     * Return true if currency exist (example $currency: "EUR", "USD")
     *
     * @param $currency
     * @return bool
     */
    public static function isAvailableCurrency($currency) {
        $currencies = new ISOCurrencies();
        if ($currencies->contains(new Currency($currency)) && $currency != '') {
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
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $currency =  $numberFormatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE);
        if ($currency != '' && $currencies->contains(new Currency($currency))) {
            return $currency;
        } else {
            return $default;
        }
    }
}