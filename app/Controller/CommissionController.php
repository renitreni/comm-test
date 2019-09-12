<?php
namespace App\Controller;

use App\Config\Fee;
use App\Controller\Features\CashProcess;

class CommissionController
{
    private $data_array;

    private $cash_in_fee;

    private $cash_out_fee;

    private $big_array;

    public function __construct($data_array)
    {
        $this->data_array   = $data_array;
        $this->cash_in_fee  = Fee::cashInFee();
        $this->cash_out_fee = Fee::cashOutFee();
    }

    public function generate()
    {
        $this->alignWeeks();

        $cash_process = new CashProcess();
        $cash_process->generate($this->big_array);
        foreach ($this->big_array as $key => $value) {
            print $value['commission'] . "\n";
        }
    }

    public function alignWeeks()
    {
        foreach ($this->data_array as $key => $value) {
            $date = cleanDate($value[0]);
            if ($value[0] != '') {
                $this->big_array[] = [
                    'id'               => $value[1],
                    'start_of_week'    => $date,
                    'date'             => $value[0],
                    'user_type'        => $value[2],
                    'operation_type'   => $value[3],
                    'operation_amount' => $value[4],
                    'currency'         => $value[5],
                    'commission'       => '0',
                ];
            }
        }
    }
}