<?php
namespace App\Config;

class EuroCurrency
{
    const EUR = 1;
    const USD = 1.1497;
    const JPY = 129.53;

    public static function convertTo($currency, $value)
    {
        return $value / constant('self::' . $currency);
    }

    public static function returnTo($currency, $value)
    {
        return $value * constant('self::' . $currency);
    }
}