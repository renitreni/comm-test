<?php
namespace App\Controller\Features;

use App\Config\EuroCurrency;
use App\Config\Fee;

class CashOut
{
    private $fee;

    private $max_comm;

    private $prev_date;

    private $discounted;

    private $max_per_week;

    private $id;

    public function __construct($prev_date, $id)
    {
        $this->prev_date    = $prev_date;
        $this->id           = $id;
        $this->max_per_week = 1000;
        $this->discounted   = 0;
        $this->fee          = Fee::cashOutFee();
        $this->max_comm     = 0.50;
    }

    public function process(&$data, $key, $value)
    {
        $property = $value['user_type'] . "Persons";
        $this->$property($data, $key, $value);

        return $data;
    }

    private function legalPersons(&$data, $key, $value)
    {
        $op_amt = EuroCurrency::returnTo($value['currency'], $value['operation_amount']);
        getCommissionFee($commission, $op_amt, $this->fee);
        checkMaxCashOut($commission, $this->max_comm);
        $value['commission'] = $commission;
        $data[$key]          = $value;
    }

    private function naturalPersons(&$data, $key, $value)
    {
        $currency = $data[$key]['currency'];
        $op_amt   = $data[$key]['operation_amount'];

        if (($this->prev_date != $value['start_of_week'] || $this->id != $value['id'])) {
            $this->max_per_week = 1000;
            $this->discounted   = 0;
        }

        if ($this->discounted < 3) {
            $op_amt             = $op_amt - EuroCurrency::returnTo($currency, $this->max_per_week);
            $this->max_per_week -= EuroCurrency::convertTo($currency, $data[$key]['operation_amount']);
            $this->checkValue($this->max_per_week);
            $this->discounted++;
        }

        getCommissionFee($data[$key]['commission'], round($op_amt), $this->fee);
        $this->prev_date = $value['start_of_week'];
        $this->id        = $value['id'];
    }

    public function checkValue(&$value)
    {
        $value = $value < 0 ? 0 : $value;
    }
}