<?php
namespace App\Config;

class Fee
{
    const CASH_IN_FEE  = 0.03;
    const CASH_OUT_FEE = 0.3;

    public static function cashInFee(): float
    {
        return self::CASH_IN_FEE / 100;
    }

    public static function cashOutFee(): float
    {
        return self::CASH_OUT_FEE / 100;
    }
}