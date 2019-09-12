<?php
namespace App\Controller\Features;

class CashProcess
{
    public function generate(&$big_array)
    {
        $hold_date = $big_array[0]['start_of_week'];
        $id        = $big_array[0]['id'];
        $cash_in   = new CashIn();
        $cash_out  = new CashOut($hold_date, $id);
        foreach ($big_array as $key => $value) {
            $property = ${$value['operation_type']};
            $property->process($big_array, $key, $value);
        }
    }
}