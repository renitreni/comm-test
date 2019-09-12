<?php

use PHPUnit\Framework\TestCase;

class InstanceTest extends TestCase
{
    public function testCashOutFee(): void
    {
        $this->expectOutputString(0.003);
        print \App\Config\Fee::cashOutFee();
    }

    public function testCashInFee(): void
    {
        $this->expectOutputString(0.0003);
        print \App\Config\Fee::cashInFee();
    }

    public function testFeesAreNotEqual(): void
    {
        $this->assertNotEquals(
            \App\Config\Fee::cashOutFee(),
            \App\Config\Fee::cashInFee()
        );
    }

    public function testCurrencyConversionJpyToEuro(): void
    {
        $this->expectOutputString(3000 / \App\Config\EuroCurrency::JPY);
        print \App\Config\EuroCurrency::convertTo('JPY', 3000);
    }

    public function testCurrencyConversionUsdToEuro(): void
    {
        $this->expectOutputString(100 / \App\Config\EuroCurrency::USD);
        print \App\Config\EuroCurrency::convertTo('USD', 100);
    }

    public function testCurrencyConversionEuroToJpy(): void
    {
        $this->expectOutputString(3000 * \App\Config\EuroCurrency::EUR);
        print \App\Config\EuroCurrency::returnTo('EUR', 3000);
    }

    public function testCurrencyConversionEuroToUsd(): void
    {
        $this->expectOutputString(100 * \App\Config\EuroCurrency::EUR);
        print \App\Config\EuroCurrency::returnTo('EUR', 100);
    }

    public function testCashOutProcess(): void
    {
        $testValue = [["\ufeff12\/31\/14","4","natural","cash_out","1200","EUR"]];
        $this->expectOutputString("0.60\n");
        $commission = new \App\Controller\CommissionController($testValue);
        print $commission->generate();
    }

    public function testCashInProcess(): void
    {
        $testValue = [["\ufeff12\/31\/14","4","natural","cash_in","1200","EUR"]];
        $this->expectOutputString("0.36\n");
        $commission = new \App\Controller\CommissionController($testValue);
        print $commission->generate();
    }
}