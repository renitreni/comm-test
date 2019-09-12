<?php
namespace App\Controller\Features;

use App\Config\Fee;
class CashIn
{
    private $fee;

    private $max_comm;

    public function __construct()
    {
        $this->fee      = Fee::cashInFee();
        $this->max_comm = 5;
    }

    public function process(&$data, $key, $value)
    {
        getCommissionFee($data[$key]['commission'], $value['operation_amount'], $this->fee);
        checkMaxCashIn($data[$key]['commission'], $this->max_comm);
    }
}